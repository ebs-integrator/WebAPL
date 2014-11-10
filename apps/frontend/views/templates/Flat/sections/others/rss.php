<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<rss version="2.0">

    <channel>
        <title><?= SettingsModel::one('sitename_' . \WebAPL\Language::ext()); ?></title>
        <link><?= url(); ?></link>
        <description></description>
        <?php foreach ($posts as $item) { ?>
            <item>
                <title><?= htmlspecialchars($item->title); ?></title>
                <link><?= \WebAPL\Language::url('topost/' . $item->id); ?></link>
                <description><?= htmlspecialchars(htmlspecialchars_decode(Str::words(strip_tags($item->text), 200))); ?></description>
                <pubDate><?= date("D, d M Y H:i:s O", strtotime($item->created_at)); ?></pubDate>
            </item>
        <?php } ?>
    </channel>

</rss>