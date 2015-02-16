<?php
$months = array('', 'Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie');
?>

<div class="orsl">
    <ul class="orar_slider">
        <?php
        $current_month_ord = 0;
        $month_ord = 0;
        ?>
        <?php for ($year = $begin_year; $year <= $end_year; $year++) { ?>
            <?php for ($month = ($year == $begin_year ? $begin_month : 1); ($year == $end_year && $month <= $end_month) || ($year != $end_year && $month <= 12); $month++) {
                ?>
                <li><!-- luna -->
                    <div class=" w_line"></div>
                    <table class="orar">
                        <thead>
                            <tr><td colspan="7"><?= $months[$month]; ?> <?= $year; ?></td></tr>
                            <tr>
                                <td><?= varlang('luni'); ?></td><td><?= varlang('marti'); ?> </td><td><?= varlang('miercuri'); ?> </td><td><?= varlang('joi'); ?></td><td><?= varlang('vineri'); ?></td><td><?= varlang('simbata'); ?></td><td><?= varlang('duminica'); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $firstDayOfMonth = date('w', mktime(0, 0, 0, $month, 1, $year))==0?7:date('w', mktime(0, 0, 0, $month, 1, $year)); // a zero based day number


                            /* IMPORTANT STATEMENT
                              value based on the starting day of array
                              E.G. (starting_day = value):
                              Tuesday = 5
                              Wednesday = 4
                              Thursday = 3
                              Friday = 2
                              Saturday = 1
                              Sunday = 0
                              Monday = -1

                             */

                            $firstDayOfMonth = $firstDayOfMonth - 1;

                            /* END IMPORTANT STATEMENT */


                            $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));

                            echo '<tr>';

                            echo $firstDayOfMonth > 0 ? str_repeat('<td class="empty_cell">&nbsp;</td>', $firstDayOfMonth) : '';

                            $dayOfWeek = $firstDayOfMonth + 1;
                            $weekNum = 1;

                            for ($dayOfMonth = 1; $dayOfMonth <= $daysInMonth; $dayOfMonth++) {
                                $date = sprintf('%4d-%02d-%02d', $year, $month, $dayOfMonth);
                                $haveEvents = isset($events[$year][$month][$dayOfMonth]) && $events[$year][$month][$dayOfMonth];
                                ?>
                            <td class='day <?= $haveEvents ? 'haveEvents' : 'nhaveEvents'; ?>'>                            
                                <div class="cl_data <?= $month == $current_month && $year == $current_year && $dayOfMonth == $current_day ? 'active' : ''; ?>"><?= $dayOfMonth; ?></div>
                                <div class="cl_time">
                                    <ul>
                                        <?php if (isset($events[$year][$month][$dayOfMonth])) { ?>
                                            <?php foreach ($events[$year][$month][$dayOfMonth] as $event) { ?>
                                                <li><!-- eveniment -->
                                                    <p><?= $event->period; ?></p>
                                                    <div class="cl_pop">
                                                        <?php if (isset($online_persons) && in_array($event->person_id, $online_persons)) { ?>
                                                            <a href="javascript:;" data-personid="<?= $event->person_id; ?>" class="firechat-start-with"><img src="<?= res('assets/img/startchat.png'); ?>" style="display: inline;" /> <?= varlang('incepe-discutia'); ?></a>
                                                        <?php } ?>
                                                        <?php if ($event->post_id) { ?>
                                                            <a href="<?= Language::url('topost/' . $event->post_id); ?>"><?= $event->title; ?></a>
                                                        <?php } else { ?>
                                                            <span><?= $event->title; ?></span>
                                                        <?php } ?>
                                                        <?php if ($event->location) { ?>
                                                            <p><?= $event->location; ?></p>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td></td>
                            <?php
                            if ($dayOfWeek >= 7 || ($firstDayOfMonth == -1 && $dayOfWeek >= 6 && $weekNum == 1)) {
                                echo '</tr>' . "\r\n";
                                $weekNum++;
                                if ($dayOfMonth != $daysInMonth) {
                                    echo '<tr>';
                                }
                                $dayOfWeek = 1;
                            } else {
                                $dayOfWeek++;
                            }
                        }

                        echo $dayOfWeek > 1 ? str_repeat('<td class="empty_cell">&nbsp;</td>', 8 - $dayOfWeek) : '';
                        echo '</tr></table>';

                        if ($month == $current_month && $year == $current_year) {
                            $current_month_ord = $month_ord;
                        }
                        $month_ord++;
                        ?>
                        </tbody>
                    </table>
                    <div class="clearfix50"></div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>

<script>
    start_month = <?= $current_month_ord; ?>;
</script>