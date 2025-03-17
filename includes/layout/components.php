<?php
// includes/layout/components.php
function displayLogo($width, $height, $marginBottom = '3', $url = '', $text = '')
{ ?>
    <a href="<?= $url ?>" title="<?= $text ?>" class="d-inline-block mx-auto mb-<?= $marginBottom ?>">
        <img src="<?= uri() ?>/uploads/division/division.png" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $text ?>">
    </a>
    <?php }

function messageAlert($show, $message, $success = true, $align = 'left')
{
    if ($show) : ?>
        <div class="alert alert-<?= $success ? 'success' : 'danger' ?> text-<?= $align ?> auto-hide">
            <i class="fa fas fa-<?= $success ? 'info' : 'exclamation' ?>-circle mr-1"></i> <?= $message ?>
        </div>
    <?php endif;
}

function roundPill($text)
{
    $bgColor = 'primary';
    $textColor = 'light';
    switch (strtolower($text)) {
        case 'active':
            $bgColor = 'success';
            break;
        case 'transferred':
            $bgColor = 'info';
            break;
        case 'suspended':
            $bgColor = 'warning';
            $textColor = 'secondary';
            break;
        case 'resigned':
        case 'retired':
        case 'dismissed':
            $bgColor = 'danger';
            break;
        case 'deceased':
            $bgColor = 'dark';
            break;
        default:
            $bgColor = 'secondary';
            break;
    } ?>
    <span class="py-1 px-3 small bg-<?= $bgColor ?> rounded-pill text-<?= $textColor ?>"><?= $text ?></span>
<?php }

function newFeatureMark()
{ ?>
    <span class="new-feature bg-danger px-2 small ml-1 text-light font-weight-light text-capitalize rounded-pill">New</span>
<?php }

function sidebarDivider($marginBottom = '0', $autoHide = false)
{ ?>
    <hr class="sidebar-divider mb-<?= $marginBottom ?> <?= $autoHide ? 'd-none d-md-block' : '' ?>">
<?php }

function sidebarHeading($text)
{ ?>
    <div class="sidebar-heading mt-3"><?= $text ?></div>
<?php }

function sidebarToggle()
{ ?>
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
<?php }

function sex($sex)
{
    $sign = strtolower($sex) === 'male' ? 'mars' : 'venus' ?>
    <i class="<?= "fas fa-{$sign} text-{$sign} fa-2x" ?>"></i>
<?php }

function card($title, $link, $icon, $color = 'primary', $counter = null, $newFeature = false)
{ ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-<?= $color ?> shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="font-weight-bold text-<?= $color ?> text-uppercase mb-1">
                            <?= $title;
                            if ($newFeature) {
                                newFeatureMark();
                            } ?>
                        </div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $counter !== null ? $counter : '&nbsp;' ?></div>
                    </div>

                    <div class="col-auto">
                        <i class="fas <?= $icon ?> fa-3x text-<?= $color ?>" aria="hidden"></i>
                    </div>
                </div>
            </div>

            <div class="card-footer py-1 text-right">
                <a class="small text-<?= $color ?>" href="<?= $link ?>">View Details</a>
            </div>
        </div>
    </div>
<?php }

function cardMini($title, $link, $icon, $color = 'primary')
{ ?>
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-<?= $color ?> shadow h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <i class="fas <?= $icon ?> fa-3x text-<?= $color ?>" aria="hidden"></i>
                    </div>

                    <div class="col">
                        <div class="font-weight-bold text-uppercase mb-1">
                            <a class="text-<?= $color ?>" href="<?= $link ?>">
                                <?= $title ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }

function cardMiniModal($title, $link, $icon, $color = 'primary')
{ ?>
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-<?= $color ?> shadow h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <i class="fas <?= $icon ?> fa-3x text-<?= $color ?>" aria="hidden"></i>
                    </div>

                    <div class="col">
                        <div class="font-weight-bold text-uppercase mb-1">
                            <a class="text-<?= $color ?>" href="#" data-toggle="modal" data-target="#modal" onclick="loadData('<?= $link ?>')">
                                <?= $title ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }

function scrollToTop()
{ ?>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <?php }

function showAsterisk($show = true)
{
    if ($show) : ?>
        <span class="text-danger"> *</span>
    <?php endif;
}

function modal()
{ ?>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true" data-backdrop="static">
        <div class="modal-dialog d-none">
            <div class="modal-content">
                <?php modalHeader('') ?>

                <div class="modal-body"></div>

                <div class="modal-footer">
                    <form action="" method="POST" role="form">
                        <?php cancelModalButton() ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }

function contentTitle($title)
{ ?>
    <div class="d-sm-flex">
        <h3 class="h3 mb-0 text-gray-800"><?= $title ?></h3>
    </div>
<?php }

function contentTitleWithLink($title, $link, $text = 'Back', $icon = 'fa-arrow-circle-left', $color = 'primary')
{ ?>
    <div class="d-sm-flex align-items-center justify-content-between">
        <h3 class="h3 mb-0 text-gray-800"><?= $title ?></h3>
        <?php linkButtonSplit($link, $text, $icon, $text, $color) ?>
    </div>
<?php }

function contentTitleWithModal($title, $link, $text, $icon, $color = 'primary')
{ ?>
    <div class="d-sm-flex align-items-center justify-content-between">
        <h3 class="h3 mb-0 text-gray-800"><?= $title ?></h3>
        <?php modalButtonSplit($link, $text, $icon, $text, $color) ?>
    </div>
<?php }

function sidebarMenuItem($link, $title, $icon, $condition = false, $counter = null, $newFeature = false)
{ ?>
    <li class="nav-item <?= $condition ? ' active' : '' ?>">
        <a class="nav-link d-flex align-items-center justify-content-between" href="<?= $link ?>">
            <div class="menu-item">
                <i class="fas fa-fw <?= $icon ?>"></i>
                <span>
                    <?= $title;
                    if ($newFeature) {
                        newFeatureMark();
                    } ?>
                </span>
            </div>
            <?php if ($counter !== null) : ?>
                <span class="bg-dark px-2 rounded-pill font-weight-bold"><?= $counter ?></span>
            <?php endif ?>
        </a>
    </li>
<?php }

function sidebarModalItem($link, $title, $icon, $counter = null, $newFeature = false)
{ ?>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center justify-content-between" href="#" data-toggle="modal" data-target="#modal" onclick="loadData('<?= $link ?>')">
            <div class="menu-item">
                <i class="fas fa-fw <?= $icon ?>"></i>
                <span>
                    <?= $title;
                    if ($newFeature) {
                        newFeatureMark();
                    } ?>
                </span>
            </div>
            <?php if ($counter !== null) : ?>
                <span class="bg-dark px-2 rounded-pill font-weight-bold"><?= $counter ?></span>
            <?php endif ?>
        </a>
    </li>
<?php }

function linkItem($link, $text, $newTab = false)
{ ?>
    <a href="<?= $link ?>" class="text-uppercase" target="<?= $newTab ? '_blank' : '_self' ?>"><?= $text ?></a>
<?php }

function modalItem($link, $text)
{ ?>
    <a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData('<?= $link ?>')"><?= $text ?></a>
<?php }

function linkButtonSplit($link, $text, $icon, $title = '', $color = 'primary', $newTab = false)
{ ?>
    <a href="<?= $link ?>" class="btn btn-<?= $color ?> btn-icon-split btn-sm my-1" title="<?= $title ?>" target="<?= $newTab ? '_blank' : '_self' ?>">
        <span class="icon text-white-50"><i class="fas <?= $icon ?> fa-fw"></i></span>
        <span class="text"><?= $text ?></span>
    </a>
<?php }

function modalButtonSplit($link, $text, $icon, $title = '', $color = 'primary')
{ ?>
    <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-<?= $color ?>  btn-icon-split btn-sm my-1" title="<?= $title ?>" onclick="loadData('<?= $link ?>')">
        <span class="icon text-white-50"><i class="fas <?= $icon ?> fa-fw"></i></span>
        <span class="text"><?= $text ?></span>
    </a>
<?php }

function linkDropdownItem($link, $text, $icon, $title = '', $newTab = false, $newFeature = false)
{ ?>
    <a href="<?= $link ?>" class="dropdown-item" title="<?= $title ?>" target="<?= $newTab ? '_blank' : '_self' ?>">
        <i class="fas <?= $icon ?> fa-sm fa-fw mr-1"></i>
        <?= $text;
        if ($newFeature) {
            newFeatureMark();
        } ?>
    </a>
<?php }

function downloadLinkDropdownItem($link, $text, $icon, $title, $fileName, $newTab = false, $newFeature = false)
{ ?>
    <a href="<?= $link ?>" class="dropdown-item" download="<?= $fileName ?>" title="<?= $title ?>" target="<?= $newTab ? '_blank' : '_self' ?>">
        <i class="fas <?= $icon ?> fa-sm fa-fw mr-1"></i>
        <?= $text;
        if ($newFeature) {
            newFeatureMark();
        } ?>
    </a>
<?php }

function previewLinkDropdownItem($link, $text, $icon, $title, $newFeature = false)
{ ?>
    <a href="<?= $link ?>" class="dropdown-item" title="<?= $title ?>" target="_new">
        <i class="fas <?= $icon ?> fa-sm fa-fw mr-1"></i>
        <?= $text;
        if ($newFeature) {
            newFeatureMark();
        } ?>
    </a>
<?php }

function modalDropdownItem($link, $text, $icon, $title = '', $newFeature = false)
{ ?>
    <a href="#" data-toggle="modal" data-target="#modal" class="dropdown-item" title="<?= $title ?>" onclick="loadData('<?= $link ?>')">
        <i class="fas <?= $icon ?> fa-sm fa-fw mr-1"></i>
        <?= $text;
        if ($newFeature) {
            newFeatureMark();
        } ?>
    </a>
<?php }

function dropdownEllipsis()
{ ?>
    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
    </a>
<?php }

function modalHeader($title)
{ ?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $title ?></h5>
        <button id="close-modal-button" type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>
<?php }

function modalConfirmDelete($message, $title = 'Delete', $buttonName = 'Delete', $verifier = null, $dataVerifier = null)
{ ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <?php modalHeader($title) ?>

            <div class="modal-body">
                <?= $message ?>
            </div>

            <div class="modal-footer">
                <form action="" method="POST" role="form">
                    <input type="hidden" name="verifier" value="<?= $verifier ?>">
                    <input type="hidden" name="data-verifier" value="<?= $dataVerifier ?>">
                    <input type="submit" class="btn btn-danger" name="<?= $buttonName ?>" value="Yes, Continue">
                    <?php cancelModalButton() ?>
                </form>
            </div>
        </div>
    </div>
<?php }

function cancelModalButton()
{ ?>
    <button id="cancel-modal-button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<?php }

function missingAlert($text, $icon = 'fa-times-circle', $color = 'text-danger')
{ ?>
    <div class="error mx-auto text-center <?= $color ?>"><i class="fas <?= $icon ?> fa-fw"></i></div>
    <p class="lead text-center text-gray-800 mt-1 mb-0"><?= $text ?></p>
    <p class="text-center text-gray-500 mb-0">Sorry, we couldn't find what you're looking for...</p>
<?php }

function requiredLegend($marginBottom = 2)
{ ?>
    <div class="text-danger mb-<?= $marginBottom ?>">* Required field</div>
<?php }

function progressBar($value, $min = 50)
{ ?>
    <div class="progress mt-1" title="<?= $value ?>% Complete">
        <div class="progress-bar bg-<?= $value > $min ? 'success' : 'danger' ?>" role="progressbar" aria-valuenow="<?= $value ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $value ?>%"></div>
    </div>
<?php }

function employeeProfile($picture, $name, $sex, $email, $position, $station, $status)
{ ?>
    <div class="image-container">
        <span class="d-flex justify-content-center align-middle employee-photo photo-4x rounded-circle overflow-hidden">
            <img height="100%" src="<?= $picture ?>" alt="<?= $name ?>">
        </span>
        <div class="sex-sign"><?php sex($sex) ?></div>
    </div>

    <div class="text-center text-uppercase h4 mt-3 mb-0"><?= $name ?></div>
    <div class="text-center text-lowercase m-0 small"><?= $email ?></div>
    <div class="text-center text-uppercase my-1"><?php roundPill($status) ?></div>
    <div class="text-center text-uppercase h5 mt-3 mb-1"><?= $position ?></div>
    <div class="text-center text-uppercase h6 my-1"><?= $station ?></div>
<?php }

function profilePhotoUpload($file, $photo, $label, $uri)
{ ?>
    <script>
        document.getElementById('<?= $file ?>').addEventListener('change', (event) => {
            var preview = document.getElementById('<?= $photo ?>');
            const file = event.target.files[0];
            const name = file.name;
            const lastDot = name.lastIndexOf('.');
            const ext = name.substring(lastDot + 1);
            var label = document.getElementById('<?= $label ?>');
            label.innerText = name;

            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    break;
                default:
                    preview.src = '<?= $uri ?>/assets/img/nopreview.png';
                    break;
            }
        });
    </script>
<?php }
