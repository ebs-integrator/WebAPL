<div class="dd">
    <ol class="dd-list">
        <li class="dd-item" data-id="1">
            <div class="dd-handle">Item 1</div>
        </li>
        <li class="dd-item" data-id="2">
            <div class="dd-handle">Item 2</div>
        </li>
        <li class="dd-item" data-id="3">
            <div class="dd-handle">Item 3</div>
            <ol class="dd-list">
                <li class="dd-item" data-id="4">
                    <div class="dd-handle">Item 4</div>
                </li>
                <li class="dd-item" data-id="5">
                    <div class="dd-handle">Item 5</div>
                </li>
            </ol>
        </li>
    </ol>
</div>

<script src="<?= res('assets/lib/nestable/jquery.nestable.js'); ?>"></script>
<link rel="stylesheet" href="<?= res('assets/lib/nestable/nestable.css'); ?>">

<script>
    jQuery(document).ready(function($) {
        $('.dd').nestable({ /* config options */});
    });
</script>