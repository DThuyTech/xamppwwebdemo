<?php
defined('ABSPATH') || exit;
?>
<div class="ifs-modal">
    <div class="ifs-dialog">
        <div class="ifs-header">
            <div class="ifs-title"><?php esc_html_e("Groups", 'ifolders'); ?></div>
            <div class="ifs-cancel" al-on.click="Modal.fn.close()"></div>
        </div>
        <div class="ifs-data">
            <div class="ifs-loader" al-attr.class.ifs-active="Modal.loading"></div>
            <div al-if="Modal.data.groups.loaded">
                <div class="ifs-table-toolbar">
                    <div class="ifs-right-group">
                        <div class="ifs-group" al-if="Modal.data.groups.view.total">
                            <div class="ifs-label">{{Modal.data.groups.view.first}}-{{Modal.data.groups.view.last}} of {{Modal.data.groups.view.total}}</div>
                            <div class="ifs-btn" al-on.click="Modal.fn.load(Modal.data.groups.view.page - 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 19.03125 4.28125 L 8.03125 15.28125 L 7.34375 16 L 8.03125 16.71875 L 19.03125 27.71875 L 20.46875 26.28125 L 10.1875 16 L 20.46875 5.71875 Z"/></svg>
                            </div>
                            <div class="ifs-btn" al-on.click="Modal.fn.load(Modal.data.groups.view.page + 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 12.96875 4.28125 L 11.53125 5.71875 L 21.8125 16 L 11.53125 26.28125 L 12.96875 27.71875 L 23.96875 16.71875 L 24.65625 16 L 23.96875 15.28125 Z"/></svg>
                            </div>
                        </div>
                        <div class="ifs-btn" al-on.click="Modal.fn.load()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 10.886719 4 6.617188 7.160156 4.875 11.625 L 6.71875 12.375 C 8.175781 8.640625 11.710938 6 16 6 C 19.242188 6 22.132813 7.589844 23.9375 10 L 20 10 L 20 12 L 27 12 L 27 5 L 25 5 L 25 8.09375 C 22.808594 5.582031 19.570313 4 16 4 Z M 25.28125 19.625 C 23.824219 23.359375 20.289063 26 16 26 C 12.722656 26 9.84375 24.386719 8.03125 22 L 12 22 L 12 20 L 5 20 L 5 27 L 7 27 L 7 23.90625 C 9.1875 26.386719 12.394531 28 16 28 C 21.113281 28 25.382813 24.839844 27.125 20.375 Z"/></svg>
                        </div>
                    </div>
                </div>
                <table class="ifs-table" >
                    <thead>
                    <tr>
                        <th class="ifs-field-check"><input type="checkbox" al-checked="Modal.data.groups.checked" al-on.change="App.fn.selectAll($event, Modal.data.groups.checked, Modal.data.groups, Modal.scope)"></th>
                        <th class="ifs-field-text"><?php esc_html_e("Group Name", 'ifolders'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="ifs-can-select" al-repeat="group in Modal.data.groups.list">
                        <td class="ifs-field-check"><input type="checkbox" al-checked="group.checked" al-on.change="App.fn.selectOne($event, group.checked, Modal.data.groups, Modal.scope)"></td>
                        <td class="ifs-field-text" al-on.dblclick="Modal.fn.dblclick(group)">{{group.title}}</td>
                    </tr>
                    <tr al-repeat="i in Modal.data.groups.view.absents">
                        <td al-repeat="i in 2"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ifs-footer">
            <div class="ifs-btn ifs-cancel" al-on.click="Modal.fn.close()"><?php esc_html_e("Cancel", 'ifolders'); ?></div>
            <div class="ifs-btn ifs-submit" al-on.click="Modal.fn.submit()" al-if="Modal.data.groups.loaded"><?php esc_html_e("Select", 'ifolders'); ?></div>
        </div>
    </div>
</div>
