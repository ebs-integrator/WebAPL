<div class="search left">
    <input type="text" id="actetitle" placeholder="<?= varlang('search-label'); ?>">
    <input type="submit" id="actesearch" value="<?= varlang('search-button'); ?>" class="green_sub">

    <div class="clearfix"></div>
</div>
<div class="sort_b">
    <p><?= varlang('page-result'); ?> </p>
    <select id="jsperpage">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
</div>
<?php
$months = array(
    1 => varlang('ianuarie'),
    2 => varlang('februarie'),
    3 => varlang('martie'),
    4 => varlang('aprilie'),
    5 => varlang('mai'),
    6 => varlang('iunie'),
    7 => varlang('iulie'),
    8 => varlang('august'),
    9 => varlang('septembrie'),
    10 => varlang('octombrie'),
    11 => varlang('noiembrie'),
    12 => varlang('decembrie')
);
?>

<div class="clearfix"></div>

<div class="acte_slider acte_results" style="display: none">
    <div class="slide" data-page="1">
        <table>
            <thead>
            <tr>
                <td><?= varlang('acte-nr'); ?></td>
                <td><?= varlang('acte-title'); ?></td>
                <td><?= varlang('acte-tip'); ?></td>
                <td><?= varlang('acte-emitent'); ?></td>
                <td><?= varlang('acte-data'); ?></td>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="clndr">
    <div class="acte_slider">
        <?php foreach ($months as $month_num => $month) { ?>
            <div class="slide" data-page="1">
                <table>
                    <thead>
                    <tr>
                        <td colspan="5"><?= $month; ?> <?= $current_year; ?></td>
                    </tr>
                    <tr>
                        <td><?= varlang('acte-nr'); ?></td>
                        <td><?= varlang('acte-title'); ?></td>
                        <td><?= varlang('acte-tip'); ?></td>
                        <td><?= varlang('acte-emitent'); ?></td>
                        <td><?= varlang('acte-data'); ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($list[$month_num])) { ?>
                        <?php foreach ($list[$month_num] as $doc) { ?>
                            <tr>
                                <td><?= $doc->doc_nr; ?></td>
                                <td class="searchin"><a href="<?= url($doc->path); ?>"><?= $doc->title; ?></a></td>
                                <td><?= $doc->type; ?></td>
                                <td><?= $doc->emitent; ?></td>
                                <td><?= date("d.m.Y", strtotime($doc->date_upload)); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="jspages pag">
                    <span class="w_p"><?= varlang('acte-search'); ?></span>
                    <ul></ul>
                </div>
                <div class="clearfix10"></div>
            </div>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>

<script>
    var start_month = <?= $current_month - 1; ?>;

    var generatePagination = function (total, perpage) {
        $(".acte_slider .slide").each(function () {
            var currentPage = parseInt($(this).attr('data-page'));
            var total = 0;
            if (queryTitle.length === 0) {
                total = $(this).find('tbody tr').length;
            } else {
                total = $(this).find('tbody .searchin:contains("' + queryTitle + '")').closest("tr").length;
            }
            var pages = Math.ceil(total / perPage);

            $(this).find(".jspages ul").html('');
            if (pages > 1) {

                $(this).find("tbody tr").hide();
                var rowStart = (currentPage - 1) * perPage;
                var rowEnd = rowStart + perPage;
                if (queryTitle.length === 0) {
                    $(this).find('tbody tr').slice(rowStart, rowEnd).show();
                } else {
                    $(this).find('tbody .searchin:contains("' + queryTitle + '")').closest("tr").slice(rowStart, rowEnd).show();
                }


                $(this).find(".jspages").show();
                for (var page = 1; page <= pages; page++) {
                    if (currentPage === page) {
                        $(this).find(".jspages ul").append('<li class="active"><span>' + page + '</span></li>');
                    } else {
                        $(this).find(".jspages ul").append('<li><a href=\'javascript:;\' class=\'pgcl\' data-page="' + page + '">' + page + '</a></li>');
                    }
                }
            } else {
                $(this).find(".jspages").hide();
                if (queryTitle.length === 0) {
                    $(this).find('tbody tr').show();
                } else {
                    $(this).find('tbody .searchin:contains("' + queryTitle + '")').closest("tr").show();
                }
            }
        });

        slider.reloadSlider();
    }

    String.prototype.removeDiacritics = function () {
        var diacritics = [
            [/[\300-\306]/g, 'A'],
            [/[\340-\346]/g, 'a'],
            [/[\310-\313]/g, 'E'],
            [/[\350-\353]/g, 'e'],
            [/[\314-\317]/g, 'I'],
            [/[\354-\357]/g, 'i'],
            [/[\322-\330]/g, 'O'],
            [/[\362-\370]/g, 'o'],
            [/[\331-\334]/g, 'U'],
            [/[\371-\374]/g, 'u'],
            [/[\321]/g, 'N'],
            [/[\361]/g, 'n'],
            [/[\307]/g, 'C'],
            [/[\347]/g, 'c'],
        ];
        var s = this;
        for (var i = 0; i < diacritics.length; i++) {
            s = s.replace(diacritics[i][0], diacritics[i][1]);
        }
        return s;
    }

    var queryTitle = '';
    var perPage = 10;
    var slider = null;
    jQuery(document).ready(function ($) {
        perPage = parseInt($("#jsperpage").val());

        slider = $('.acte_slider:not(.acte_results)').bxSlider({
            pager: false,
            controls: true,
            adaptiveHeight: true,
            startSlide: typeof start_month !== 'undefined' ? start_month : 0
        });

        generatePagination();

        $("#jsperpage").on('change', function () {
            perPage = parseInt($(this).val());
            generatePagination();
        });

        $('body').on('click', ".pgcl", function () {
            var page = $(this).attr('data-page');
            $(this).closest(".slide").attr('data-page', page);
            generatePagination();
        });

        $("#actesearch").click(function () {
            queryTitle = $("#actetitle").val();
            if (queryTitle.length > 0) {
                $(".acte_results tbody").html(
                    $('.acte_slider tbody .searchin a').filter(function (index) {
                        return $(this).text().removeDiacritics().indexOf(queryTitle.removeDiacritics()) > -1;
                    }).closest("tr").show().clone()
                );

                $(".acte_results").show();
                $(".clndr, .sort_b").hide();
            } else {
                $(".acte_results").hide();
                $(".acte_slider tbody tr, .clndr, .sort_b").show();
                generatePagination();
            }
        });

    });
</script>