
            <table class="table table-bordered">
                <tr>
                    <th>Name: </th>
                    <td>
                        <input type="text" name="menu[name]" class='form-control' value='<?= isset($menu['name']) ? $menu['name'] : ''; ?>' />
                    </td>
                </tr>
                <tr>
                    <th>Enabled: </th>
                    <td>
                        <input type="checkbox" name="menu[enabled]" class='make-switch' <?= isset($menu['enabled']) && $menu['enabled'] ? 'checked' : ''; ?> />
                    </td>
                </tr>
            </table>
