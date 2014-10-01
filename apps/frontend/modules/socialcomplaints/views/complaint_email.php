A aparut o noua inregistrare:
<br><br>
<table>
    <tr>
        <td><b>Name</b></td>
        <td><?= $complaint->username; ?></td>
    </tr>
    <tr>
        <td><b>Email</b></td>
        <td><?= $complaint->email; ?></td>
    </tr>
    <tr>
        <td><b>Address</b></td>
        <td><?= $complaint->address; ?></td>
    </tr>
    <tr>
        <td><b>Title</b></td>
        <td><?= $complaint->title; ?></td>
    </tr>
    <tr>
        <td><b>Text</b></td>
        <td><?= $complaint->text; ?></td>
    </tr>
    <tr>
        <td><b>Date</b></td>
        <td><?= date("Y-m-d H:i:s"); ?></td>
    </tr>
    <tr>
        <td><b>Status</b></td>
        <td><?= $complaint->is_private ? 'Private' : 'Public'; ?></td>
    </tr>
</table>