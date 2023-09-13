<?php
defined('ABSPATH') || exit;
?>
<div class="ifs-modal">
    <div class="ifs-dialog">
        <div class="ifs-header">
            <div class="ifs-title"><?php esc_html_e("User Group", 'ifolders'); ?></div>
            <div class="ifs-cancel" al-on.click="Modal.fn.close()"></div>
        </div>
        <div class="ifs-data">
            <div class="ifs-loader" al-attr.class.ifs-active="Modal.loading"></div>
            <div al-if="Modal.data.rights.loaded">
                <input class="ifs-text" al-value="Modal.data.title" placeholder="<?php esc_html_e("Group name", 'ifolders'); ?>">
                <label>
                    <input type="checkbox" al-checked="Modal.data.enabled">
                    <?php esc_html_e("Enabled", 'ifolders'); ?>
                </label>
                <label>
                    <input type="checkbox" al-checked="Modal.data.shared">
                    <?php esc_html_e("Shared (users of this group will see each other's folders)", 'ifolders'); ?>
                </label>
                <p><?php esc_html_e("Add a user to the group and set rights.", 'ifolders'); ?></p>
                <div class="ifs-table-toolbar ifs-green">
                    <div class="ifs-left-group">
                        <div class="ifs-btn" al-on.click="Modal.fn.rights.selectUsers(Modal.fn.rights.addUsers)" title="<?php esc_html_e("Add user", 'ifolders'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 15 10 L 15 15 L 10 15 L 10 17 L 15 17 L 15 22 L 17 22 L 17 17 L 22 17 L 22 15 L 17 15 L 17 10 Z"/></svg>
                        </div>
                        <div class="ifs-btn" al-if="Modal.data.rights.checked" al-on.click="Modal.fn.rights.delete()" title="<?php esc_html_e("Delete selected users", 'ifolders'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"/></svg>
                        </div>
                    </div>
                    <div class="ifs-right-group">
                    </div>
                </div>
                <table class="ifs-table">
                    <thead>
                    <tr>
                        <th class="ifs-field-check"><input type="checkbox" al-checked="Modal.data.rights.checked" al-on.change="App.fn.selectAll($event, Modal.data.rights.checked, Modal.data.rights, Modal.scope)"></th>
                        <th class="ifs-field-text"><?php esc_html_e('User', 'ifolders'); ?></th>
                        <th class="ifs-field-text"><?php esc_html_e('Create', 'ifolders'); ?></th>
                        <th class="ifs-field-text"><?php esc_html_e('View', 'ifolders'); ?></th>
                        <th class="ifs-field-text"><?php esc_html_e('Edit', 'ifolders'); ?></th>
                        <th class="ifs-field-text"><?php esc_html_e('Delete', 'ifolders'); ?></th>
                        <th class="ifs-field-text"><?php esc_html_e('Attach', 'ifolders'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="ifs-can-select" al-repeat="right in Modal.data.rights.list">
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.checked" al-on.change="App.fn.selectOne($event, right.checked, Modal.data.rights, Modal.scope)"></td>
                        <td class="ifs-field-text">{{right.user}}</td>
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.c"></td>
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.v"></td>
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.e"></td>
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.d"></td>
                        <td class="ifs-field-check"><input type="checkbox" al-checked="right.a"></td>
                    </tr>
                    <tr al-repeat="i in Modal.data.rights.view.absents">
                        <td class="ifs-field-check"></td>
                        <td class="ifs-field-text"></td>
                        <td class="ifs-field-check"></td>
                        <td class="ifs-field-check"></td>
                        <td class="ifs-field-check"></td>
                        <td class="ifs-field-check"></td>
                        <td class="ifs-field-check"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ifs-footer">
            <div class="ifs-btn ifs-cancel" al-on.click="Modal.fn.close()"><?php esc_html_e("Cancel", 'ifolders'); ?></div>
            <div class="ifs-btn ifs-submit" al-on.click="Modal.fn.submit()"><?php esc_html_e("Save", 'ifolders'); ?></div>
        </div>
    </div>
</div>