<?php
// dts/track/track-document.php
?>

<div class="text-center py-0">
    <div class="error mx-auto"><i class="fas fa-search fa-fw"></i></div>
    <p class="lead text-gray-800 mt-1 mb-0">Search document</p>
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
            <p class="text-gray-500 px-2 mb-4">Track paper trail of documents submitted to the Schools Division Office created by schools, sections and offices within the schools division.</p>
        </div>
    </div>

    <form class="mx-auto mb-4" method="POST" action="">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
                <div class="input-group">
                    <input type="text" class="form-control small" placeholder="Search document..." aria-label="Search" name="primary-search-text" value="<?= $searchText ?>" autofocus required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="primary-search-button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>