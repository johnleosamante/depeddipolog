<?php
// dts/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'dts';
$page = $appTitle = 'Document Tracking System';

if (!isset($userId)) {
	redirect(uri() . '/login');
}

if (!isset($portal) || empty($portal)) {
	redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
	$search = sanitize($_POST['primary-search-text']);

	$documents = documentSearch($search, $station);

	if (numRows($documents) === 1) {
		redirect(customUri('dts', 'Document Information', $search));
	}

	redirect(customUri('dts', 'Document Search', $search));
}

if (isset($_POST['save-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$purpose = sanitize($_POST['purpose']);
	$type = sanitize($_POST['document-type']);
	$details = sanitize($_POST['details']);
	$destination = $isSchoolPortal ? 'REC' :  sanitize($_POST['destination']);
	$attachment = isset($_POST['file-verifier']) ? decipher($_POST['file-verifier']) : null;
	$logMessage = '';
	$showAlert = true;

	$year = date('y');
	$documentId = strlen($documentId) > 0 ? $documentId : $code . '-' . $year . '-' . sprintf("%05d", countDocumentsFrom($station, $year, $code) + 1);
	$uploadDirectory = root() . '/uploads/attachments/' . cipher($documentId);

	$allowedTypes = [
		'image/jpeg',
		'image/png',
		'image/gif',
		'application/pdf',
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	];

	if (numRows(document($documentId)) === 0) {
		$status = 'saved';
		$description = sanitize($_POST['description']);
		$section = section($code);

		if (numRows($section) > 0) {
			$headId = fetchAssoc($section)['head'];
		} else {
			$school = schoolById($code);
			$headId = numRows($school) > 0 ? fetchAssoc($school)['head'] : '';
		}

		if (empty($description)) {
			$message = 'No new document has been created. Please provide a description for the document.';
			$success = false;
			return;
		}

		createDocument($documentId, $description, $type, $station, $purpose, $headId, $details);
		createDocumentLog($documentId, $userId, $station, $destination, $purpose, 'New', $details);

		$logMessage = 'Created document';
	} else {
		$status = 'updated';
		$updateDescription = false;
		$description = '';

		if ($isDescriptionEditable) {
			$updateDescription = true;
			$description = isset($_POST['description']) ? sanitize($_POST['description']) : null;
		}

		updateDocument($documentId, $description, $type, $purpose, $details, $updateDescription);
		updateDocumentLog($documentId, $userId, $station, $destination, $purpose, 'New', $details);

		$logMessage = 'Updated document';
	}

	if (affectedRows()) {
		$upload_response = '';

		if (!empty($_FILES['file-upload']['name'][0])) {
			if (!is_dir($uploadDirectory)) {
				mkdir($uploadDirectory, 0777, true);
			}

			foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmp_name) {
				$fileName = basename($_FILES['file-upload']['name'][$key]);
				$fileType = $_FILES['file-upload']['type'][$key];
				$fileSize = $_FILES['file-upload']['size'][$key];
				$targetFilePath = $uploadDirectory . '/' . time() . '_' . $fileName;

				if (!in_array($fileType, $allowedTypes)) {
					$upload_response .= "<br>File type not allowed: $fileName";
					continue;
				}

				if ($fileSize > $fileUploadSizeLimit) {
					$upload_response .= "<br>File too large (Max 20MB): $fileName";
					continue;
				}

				if (move_uploaded_file($tmp_name, $targetFilePath)) {
					$attachment = $targetFilePath;
					$upload_response .= "<br>File uploaded: $fileName";
				} else {
					$upload_response .= "<br>Error uploading: $fileName";
				}
			}
		}

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been ' . $status . ' successfully.' . $upload_response;

		createSystemLog($stationId, $userId, $logMessage, $documentId, clientIp());
	} else {
		$message = $status === 'saved' ? 'No new document has been created.' : 'No document has been updated';
		$success = false;
	}
}

if (isset($_POST['receive-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', 'Received', 'New');

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been received successfully.';

		createSystemLog($stationId, $userId, 'Received document', $documentId, clientIp());
	} else {
		$message = 'No document has been received.';
		$success = false;
	}
}

if (isset($_POST['forward-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$attachment = isset($_POST['file-verifier']) ? decipher($_POST['file-verifier']) : null;
	$showAlert = true;

	$uploadDirectory = root() . '/uploads/attachments/' . cipher($documentId);

	if (!is_dir($uploadDirectory)) {
		mkdir($uploadDirectory, 0777, true);
	}

	if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
		$temp = $_FILES['file-upload']['tmp_name'];

		if ($_FILES['file-upload']['size'] > $fileUploadSizeLimit) {
			$message = 'The chosen file exceeds the upload file limit (20 MB).';
			$success = false;
			return;
		}

		$mimeType = mime_content_type($temp);
		$allowedFileTypes = ['application/pdf'];

		if (!in_array($mimeType, $allowedFileTypes)) {
			$message = 'The chosen file is not an acceptable .pdf file.';
			$success = false;
			return;
		}

		$ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);

		if (!empty($attachment) && file_exists(root() . '/' . $attachment)) {
			unlink(root() . '/' . $attachment);
		}

		$attachment = 'uploads/attachments/' . cipher($documentId) . '/' . cipher($documentId) . '-' . date('YmdHis') . '.' . $ext;

		move_uploaded_file($temp, '../' . $attachment);
	}

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, sanitize($_POST['destination']), $purpose, 'New', $details, $attachment);
		updateDocumentStatus($documentId, $purpose, 'Unread', $details);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been forwarded successfully!';

		createSystemLog($stationId, $userId, 'Forwarded document', $documentId, clientIp());
	} else {
		$message = 'No document has been forwarded.';
		$success = false;
	}
}

if (isset($_POST['complete-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = 'Completed';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';

		createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
	} else {
		$message = 'No document has been marked completed.';
		$success = false;
	}
}

if (isset($_POST['incomplete-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = 'Received';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been marked incomplete successfully.';

		createSystemLog($stationId, $userId, 'Marked incomplete document', $documentId, clientIp());
	} else {
		$message = 'No document has been marked incomplete.';
		$success = false;
	}
}

if (isset($_POST['restore-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = $isSchoolPortal ? 'For submission' : 'Restored';
	$destination = $isSchoolPortal ? 'REC' : '-';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, $destination, $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been restored successfully.';

		createSystemLog($stationId, $userId, 'Restored document', $documentId, clientIp());
	} else {
		$message = 'No document has been restored.';
		$success = false;
	}
}

if (isset($_POST['cancel-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = 'Canceled';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been canceled successfully.';

		createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
	} else {
		$message = 'No document has been canceled.';
		$success = false;
	}
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
	$from = date('Y-m-d', strtotime($_POST['date-from']));
	$to = date('Y-m-d', strtotime($_POST['date-to']));
	redirect(customUri('dts', sanitize(decipher($_GET['v']))) . '&from=' . $from . '&to=' . $to);
}
