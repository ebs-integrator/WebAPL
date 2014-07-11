<h3>Menu</h3>
<form action='<?= url('menu/save'); ?>' method='post'>

    <input type='hidden' name='id' value='<?= isset($menu['id']) ? $menu['id'] : 0; ?>' />

    <ul class="nav nav-tabs" role="tablist" id="form-tabs">
        <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
        <li><a href="#profile" role="tab" data-toggle="tab">Profile</a></li>
        <li><a href="#messages" role="tab" data-toggle="tab">Messages</a></li>
        <li><a href="#settings" role="tab" data-toggle="tab">Settings</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="general">

            <table class="table table-bordered">
                <tr>
                    <th>Name: </th>
                    <td>
                        <input type="text" name="menu[name]" class='form-control' value='<?= isset($menu['name']) ? $menu['name'] : ''; ?>' />
                    </td>
                </tr>
            </table>

        </div>
        <div class="tab-pane" id="profile">...</div>
        <div class="tab-pane" id="messages">...</div>
        <div class="tab-pane" id="settings">...</div>
    </div>

    <input type='submit' value='Save' class='btn btn-success pull-right' />

</form>

<div class='clearfix'></div>