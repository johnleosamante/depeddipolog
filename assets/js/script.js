// assets/js/chart-custom.js

if (window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
	$("div.auto-hide").fadeIn(300).delay(60000).fadeOut(300);

	let dtProps = {
		responsive: true,
		pagingType: "simple",
		lengthMenu: [
			[10, 25, 50, 75, 100, -1],
			[10, 25, 50, 75, 100, "All"],
		],
		paging: true,
		order: [],
		autoWidth: false,
		info: true,
	};

	if ($("#data-table-previous").length > 0) {
		$("#data-table-previous").DataTable(dtProps);
	}

	if ($("#data-table").length > 0) {
		$("#data-table").DataTable(dtProps);
	}

	if ($("#data-table-next").length > 0) {
		$("#data-table-next").DataTable(dtProps);
	}
});

const eyeToggle = (inputId, eyeId) => {
	const input = document.getElementById(inputId);
	const eye = document.getElementById(eyeId);

	if (input.type === "password") {
		input.type = "text";
		eye.classList.remove("fa-eye");
		eye.classList.add("fa-eye-slash");
	} else {
		input.type = "password";
		eye.classList.remove("fa-eye-slash");
		eye.classList.add("fa-eye");
	}
};

const elementExist = (element) => {
	return typeof element !== "undefined" && element !== null;
};

const loadData = (href, id = "modal") => {
	const xmlhttp = window.XMLHttpRequest
		? new XMLHttpRequest()
		: new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState === 4) {
			if (xmlhttp.status === 200) {
				document.getElementById(id).innerHTML = xmlhttp.responseText;
			} else {
				alert(
					"Bad request encountered! Please refresh the page and try again."
				);
				location.reload();
				return;
			}
		}
	};

	xmlhttp.open("GET", href);
	xmlhttp.send();
};

const generateRandomPassword = (length) => {
	const chars =
		"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*?";

	let result = "";
	for (let i = 0; i < length; i++) {
		result += chars.charAt(Math.floor(Math.random() * chars.length));
	}

	return result;
};

const generateRandomNumber = (min, max) => {
	const randomDecimal = Math.random();
	const randomInRange = randomDecimal * (max - min + 1) + min;
	const randomInteger = Math.floor(randomInRange);

	return randomInteger;
};

const checkPasswordStrength = (str) => {
	if (!hasUppercase(str)) {
		return false;
	}

	if (!hasLowercase(str)) {
		return false;
	}

	if (!hasNumber(str)) {
		return false;
	}

	if (!hasSpecialCharacter(str)) {
		return false;
	}

	if (str.length < 10) {
		return false;
	}

	return true;
};

const hasUppercase = (string) => {
	const uppercaseRegex = /[A-Z]/;
	return uppercaseRegex.test(string);
};

const hasLowercase = (string) => {
	const lowercaseRegex = /[a-z]/;
	return lowercaseRegex.test(string);
};

const hasNumber = (string) => {
	const numberRegex = /[0-9]/;
	return numberRegex.test(string);
};

const hasSpecialCharacter = (string) => {
	const specialRegex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;
	return specialRegex.test(string);
};

const checkPasswordRequirement = (elementId, condition) => {
	const element = document.getElementById(elementId);

	if (condition) {
		element.classList.add("fa-check", "text-success");
		element.classList.remove("fa-times", "text-danger");
	} else {
		element.classList.add("fa-times", "text-danger");
		element.classList.remove("fa-check", "text-success");
	}
};

const checkFieldValidity = (elementId, condition) => {
	const element = document.getElementById(elementId);

	if (condition) {
		element.classList.add("border-success");
		element.classList.remove("border-danger");
	} else {
		element.classList.add("border-danger");
		element.classList.add("border-success");
	}
};

const oldToggle = document.getElementById("old-eye-toggle");
if (elementExist(oldToggle)) {
	oldToggle.addEventListener("click", (e) => {
		e.preventDefault();
		eyeToggle("old-password", "old-eye");
	});
}

const toggle = document.getElementById("eye-toggle");
if (elementExist(toggle)) {
	toggle.addEventListener("click", (e) => {
		e.preventDefault();
		eyeToggle("password", "eye");
	});
}

const confirmToggle = document.getElementById("eye-confirm-toggle");
if (elementExist(confirmToggle)) {
	confirmToggle.addEventListener("click", (e) => {
		e.preventDefault();
		eyeToggle("password-confirm", "eye-confirm");
	});
}

const generateToggle = document.getElementById("generate-toggle");
if (elementExist(generateToggle)) {
	generateToggle.addEventListener("click", (e) => {
		e.preventDefault();
		let strongPassword = false;
		let length = generateRandomNumber(10, 16);
		let randomPassword = "";

		while (!strongPassword) {
			randomPassword = generateRandomPassword(length);
			strongPassword = checkPasswordStrength(randomPassword);
		}

		document.getElementById("password").value = randomPassword;
		document.getElementById("password-confirm").value = randomPassword;
		document.getElementById("generate-password").value = randomPassword;
	});
}

const password = document.getElementById("password");
const confirmPassword = document.getElementById("password-confirm");
const passwordRequirements = document.getElementById("password-requirements");

if (
	elementExist(password) &&
	elementExist(confirmPassword) &&
	elementExist(passwordRequirements)
) {
	let passwordValue = password.value;
	let confirmPasswordValue = confirmPassword.value;
	let validPasswordLength = passwordValue.length >= 10;
	let hasUppercasePassword = hasUppercase(passwordValue);
	let hasLowercasePassword = hasLowercase(passwordValue);
	let hasNumberPassword = hasNumber(passwordValue);
	let hasSpecialPassword = hasSpecialCharacter(passwordValue);

	checkPasswordRequirement("length", validPasswordLength);
	checkPasswordRequirement("uppercase", hasUppercasePassword);
	checkPasswordRequirement("lowercase", hasLowercasePassword);
	checkPasswordRequirement("number", hasNumberPassword);
	checkPasswordRequirement("special", hasSpecialPassword);

	checkFieldValidity(
		"password-group",
		validPasswordLength &&
			hasUppercasePassword &&
			hasLowercasePassword &&
			hasNumberPassword &&
			hasSpecialPassword
	);
	checkFieldValidity(
		"password-confirm-group",
		confirmPasswordValue.length > 0 &&
			passwordValue === confirmPasswordValue
	);

	password.addEventListener("input", () => {
		passwordValue = password.value;
		confirmPasswordValue = confirmPassword.value;
		validPasswordLength = passwordValue.length >= 10;
		hasUppercasePassword = hasUppercase(passwordValue);
		hasLowercasePassword = hasLowercase(passwordValue);
		hasNumberPassword = hasNumber(passwordValue);
		hasSpecialPassword = hasSpecialCharacter(passwordValue);

		checkPasswordRequirement("length", validPasswordLength);
		checkPasswordRequirement("uppercase", hasUppercasePassword);
		checkPasswordRequirement("lowercase", hasLowercasePassword);
		checkPasswordRequirement("number", hasNumberPassword);
		checkPasswordRequirement("special", hasSpecialPassword);

		checkFieldValidity(
			"password-group",
			validPasswordLength &&
				hasUppercasePassword &&
				hasLowercasePassword &&
				hasNumberPassword &&
				hasSpecialPassword
		);
		checkFieldValidity(
			"password-confirm-group",
			confirmPasswordValue.length > 0 &&
				passwordValue === confirmPasswordValue
		);
	});

	confirmPassword.addEventListener("input", () => {
		passwordValue = password.value;
		confirmPasswordValue = confirmPassword.value;

		checkFieldValidity(
			"password-confirm-group",
			confirmPasswordValue.length > 0 &&
				passwordValue === confirmPasswordValue
		);
	});
}

const beforeTitle = document.getElementById("before-title");
const afterTitle = document.getElementById("after-title");
const userName = document.getElementById("user-name");
const preview = document.getElementById("preview");

if (
	elementExist(beforeTitle) &&
	elementExist(afterTitle) &&
	elementExist(userName) &&
	elementExist(preview)
) {
	let beforeTitleValue = beforeTitle.value;
	let afterTitleValue = afterTitle.value;
	let userNameValue = userName.value;

	beforeTitle.addEventListener("input", () => {
		beforeTitleValue =
			beforeTitle.value.length > 0 ? beforeTitle.value + " " : "";
		afterTitleValue =
			afterTitle.value.length > 0 ? ", " + afterTitle.value : "";
		preview.value = beforeTitleValue + userName.value + afterTitleValue;
	});

	afterTitle.addEventListener("input", () => {
		beforeTitleValue =
			beforeTitle.value.length > 0 ? beforeTitle.value + " " : "";
		afterTitleValue =
			afterTitle.value.length > 0 ? ", " + afterTitle.value : "";
		preview.value = beforeTitleValue + userName.value + afterTitleValue;
	});
}
