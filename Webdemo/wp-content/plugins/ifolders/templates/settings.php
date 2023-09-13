<?php
defined('ABSPATH') || exit;
?>
<div class="ifs-wrap">
    <div class="ifs-app-settings" id="ifs-app-settings" style="display:none;">
        <div class="ifs-main-lock" id="ifs-main-lock"></div>
        <div class="ifs-main-header">
            <div class="ifs-title"><?php esc_html_e('iFolders Settings', 'ifolders'); ?></div>
            <div class="ifs-loader" id="ifs-loader"></div>
        </div>
        <div class="ifs-main-tabs">
            <div class="ifs-main-tab" al-attr.class.ifs-active="App.ui.tabs.fn.is('general')" al-on.click="App.ui.tabs.fn.click('general')"><?php esc_html_e('General', 'ifolders'); ?></div>
            <div class="ifs-main-tab" al-attr.class.ifs-active="App.ui.tabs.fn.is('rights')" al-on.click="App.ui.tabs.fn.click('rights')"><?php esc_html_e('Permissions', 'ifolders'); ?></div>
            <div class="ifs-main-tab" al-attr.class.ifs-active="App.ui.tabs.fn.is('data')" al-on.click="App.ui.tabs.fn.click('data')"><?php esc_html_e('Data', 'ifolders'); ?></div>
        </div>
        <div class="ifs-main-data" al-attr.class.ifs-active="App.ui.tabs.fn.is('general')">
            <div class="ifs-two-columns">
                <div class="ifs-column-1">
                    <h3><?php esc_html_e('Plugin Options', 'ifolders'); ?></h3>
                    <p><?php esc_html_e('Use this section to set main plugin options.', 'ifolders'); ?></p>
                    <table class="ifs-main-table ifs-no-border" al-if="App.data.config">
                        <tbody>
                        <tr>
                            <th><?php esc_html_e('Purchase Code', 'ifolders'); ?></th>
                            <td>
                                <div class="ifs-input-group">
                                    <input class="ifs-input ifs-monospace" type="text" placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX" maxlength="36" al-value="App.data.code" al-if="!App.data.ticket">
                                    <input class="ifs-input ifs-monospace ifs-readonly" type="text" maxlength="36" readonly al-value="App.data.ticket.code" al-if="App.data.ticket">
                                    <div class="ifs-button ifs-activate" al-on.click="App.fn.ticket.activate()" al-if="!App.data.ticket"><?php esc_html_e('Activate License', 'ifolders'); ?></div>
                                    <div class="ifs-button ifs-deactivate" al-on.click="App.fn.ticket.deactivate()" al-if="App.data.ticket"><?php esc_html_e('Deactivate License', 'ifolders'); ?></div>
                                </div>
                                <div class="ifs-ticket" al-if="App.data.ticket">
                                    <div class="ifs-rows">
                                        <div class="ifs-row"><b>Product:</b> {{App.data.ticket.product}}</div>
                                        <div class="ifs-row"><b>Domain:</b> {{App.data.ticket.site}}</div>
                                        <div class="ifs-row"><b>Supported Until:</b> {{App.data.ticket.supported_until}}</div>
                                    </div>
                                    <div class="ifs-info ifs-valid">
                                        <div class="ifs-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d=" M 12 1.5 C 6.21 1.5 1.5 6.21 1.5 12 C 1.5 17.79 6.21 22.5 12 22.5 C 17.79 22.5 22.5 17.79 22.5 12 C 22.5 6.21 17.79 1.5 12 1.5 Z  M 12 3.115 C 16.916 3.115 20.885 7.084 20.885 12 C 20.885 16.916 16.916 20.885 12 20.885 C 7.084 20.885 3.115 16.916 3.115 12 C 3.115 7.084 7.084 3.115 12 3.115 Z  M 7.734 9.4 L 6.573 10.561 L 11.419 15.407 L 12 15.963 L 12.581 15.407 L 17.427 10.561 L 16.266 9.4 L 12 13.666 L 7.734 9.4 Z " />
                                            </svg>
                                        </div>
                                        <div class="ifs-title"><?php esc_html_e('The license is active and valid for this domain', 'ifolders'); ?></div>
                                    </div>
                                    <!--
                                    <div class="ifs-info ifs-invalid">
                                        <div class="ifs-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d=" M 12 1.5 C 6.21 1.5 1.5 6.21 1.5 12 C 1.5 17.79 6.21 22.5 12 22.5 C 17.79 22.5 22.5 17.79 22.5 12 C 22.5 6.21 17.79 1.5 12 1.5 Z  M 12 3.25 C 16.843 3.25 20.75 7.157 20.75 12 C 20.75 16.843 16.843 20.75 12 20.75 C 7.157 20.75 3.25 16.843 3.25 12 C 3.25 7.157 7.157 3.25 12 3.25 Z  M 11.125 6.75 L 11.125 13.75 L 12.875 13.75 L 12.875 6.75 L 11.125 6.75 Z  M 11.125 15.5 L 11.125 17.25 L 12.875 17.25 L 12.875 15.5 L 11.125 15.5 Z " />
                                            </svg>
                                        </div>
                                        <div class="ifs-title">The license is invalid for this domain.<br>Please check your purchase code, try to deactivate and activate the license again or contact support.</div>
                                    </div>
                                    -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Access roles', 'ifolders'); ?></th>
                            <td>
                                <p><?php esc_html_e('Only selected user roles have access to the folders', 'ifolders'); ?></p>
                                <small><?php esc_html_e('(these are general settings, use the "permissions" tab to give the final rights to users)', 'ifolders'); ?></small>
                                <label al-repeat="(key,value) in App.data.roles"><input type="checkbox" value="{{value.id}}" al-on.change="App.fn.config.onAccessRoleChange($event, value)" al-attr.checked="App.fn.config.isAccessRoleChecked(value)">{{value.name}}</label>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Default folder color', 'ifolders'); ?></th>
                            <td>
                                <div class="ifs-color-picker-wrap"><div id="ifs-default-folder-color" class="ifs-color-picker"></div></div>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Disable folder counter', 'ifolders'); ?></th>
                            <td>
                                <label><input type="checkbox" al-checked="App.data.config.disable_counter"><?php esc_html_e('Disable showing number of items in each folder', 'ifolders'); ?></label>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Disable ajax refresh', 'ifolders'); ?></th>
                            <td>
                                <label><input type="checkbox" al-checked="App.data.config.disable_ajax"><?php esc_html_e('Disable ajax refresh in list view', 'ifolders'); ?></label>
                                <small><?php esc_html_e('(set when you experience problems using plugins alongside iFolders that alter the media library list view)', 'ifolders'); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Infinite scrolling', 'ifolders'); ?></th>
                            <td>
                                <label><input type="checkbox" al-checked="App.data.config.infinite_scrolling"><?php esc_html_e('Enable the media library infinite scrolling instead of the "load more" button', 'ifolders'); ?></label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="ifs-button" al-on.click="App.fn.config.save()"><?php esc_html_e('Save', 'ifolders'); ?></div>
                </div>
                <div class="ifs-column-2 ifs-promo">
                </div>
            </div>
        </div>
        <div class="ifs-main-data" al-attr.class.ifs-active="App.ui.tabs.fn.is('rights')">
            <div class="ifs-two-columns">
                <div class="ifs-column-1">
                    <h3><?php esc_html_e('User Groups', 'ifolders'); ?></h3>
                    <p><?php esc_html_e('Use this section to create and manage user groups. Within a group, you can set permissions for each user to work with folders (create, view, edit, delete, and attach).', 'ifolders'); ?></p>
                    <div class="ifs-table-toolbar ifs-green">
                        <div class="ifs-left-group">
                            <div class="ifs-btn" al-on.click="App.fn.groups.add()" title="<?php esc_html_e('Add user group', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 15 10 L 15 15 L 10 15 L 10 17 L 15 17 L 15 22 L 17 22 L 17 17 L 22 17 L 22 15 L 17 15 L 17 10 Z"/></svg>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.groups.edit()" al-if="App.data.groups.selected" title="<?php esc_html_e('Edit user group', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 23.90625 3.96875 C 22.859375 3.96875 21.8125 4.375 21 5.1875 L 5.1875 21 L 5.125 21.3125 L 4.03125 26.8125 L 3.71875 28.28125 L 5.1875 27.96875 L 10.6875 26.875 L 11 26.8125 L 26.8125 11 C 28.4375 9.375 28.4375 6.8125 26.8125 5.1875 C 26 4.375 24.953125 3.96875 23.90625 3.96875 Z M 23.90625 5.875 C 24.410156 5.875 24.917969 6.105469 25.40625 6.59375 C 26.378906 7.566406 26.378906 8.621094 25.40625 9.59375 L 24.6875 10.28125 L 21.71875 7.3125 L 22.40625 6.59375 C 22.894531 6.105469 23.402344 5.875 23.90625 5.875 Z M 20.3125 8.71875 L 23.28125 11.6875 L 11.1875 23.78125 C 10.53125 22.5 9.5 21.46875 8.21875 20.8125 Z M 6.9375 22.4375 C 8.136719 22.921875 9.078125 23.863281 9.5625 25.0625 L 6.28125 25.71875 Z"/></svg>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.groups.delete()" al-if="App.data.groups.checked" title="<?php esc_html_e('Delete selected user groups', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"/></svg>
                            </div>
                        </div>
                        <div class="ifs-right-group">
                            <div class="ifs-group" al-if="App.data.groups.view.total">
                                <div class="ifs-label">{{App.data.groups.view.first}}-{{App.data.groups.view.last}} of {{App.data.groups.view.total}}</div>
                                <div class="ifs-btn" al-on.click="App.fn.groups.load(App.data.groups.view.page - 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 19.03125 4.28125 L 8.03125 15.28125 L 7.34375 16 L 8.03125 16.71875 L 19.03125 27.71875 L 20.46875 26.28125 L 10.1875 16 L 20.46875 5.71875 Z"/></svg>
                                </div>
                                <div class="ifs-btn" al-on.click="App.fn.groups.load(App.data.groups.view.page + 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 12.96875 4.28125 L 11.53125 5.71875 L 21.8125 16 L 11.53125 26.28125 L 12.96875 27.71875 L 23.96875 16.71875 L 24.65625 16 L 23.96875 15.28125 Z"/></svg>
                                </div>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.groups.load()" title="<?php esc_html_e('Refresh', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 10.886719 4 6.617188 7.160156 4.875 11.625 L 6.71875 12.375 C 8.175781 8.640625 11.710938 6 16 6 C 19.242188 6 22.132813 7.589844 23.9375 10 L 20 10 L 20 12 L 27 12 L 27 5 L 25 5 L 25 8.09375 C 22.808594 5.582031 19.570313 4 16 4 Z M 25.28125 19.625 C 23.824219 23.359375 20.289063 26 16 26 C 12.722656 26 9.84375 24.386719 8.03125 22 L 12 22 L 12 20 L 5 20 L 5 27 L 7 27 L 7 23.90625 C 9.1875 26.386719 12.394531 28 16 28 C 21.113281 28 25.382813 24.839844 27.125 20.375 Z"/></svg>
                            </div>
                        </div>
                    </div>
                    <table class="ifs-table">
                        <thead>
                        <tr>
                            <th class="ifs-field-check"><input type="checkbox" al-checked="App.data.groups.checked" al-on.change="App.fn.selectAll($event, App.data.groups.checked, App.data.groups, App.scope)">
                            <th class="ifs-field-text"><?php esc_html_e('Group Name', 'ifolders'); ?></th>
                            <th class="ifs-field-text"><?php esc_html_e('Enabled', 'ifolders'); ?></th>
                            <th class="ifs-field-text"><?php esc_html_e('Shared', 'ifolders'); ?></th>
                            <th class="ifs-field-date"><?php esc_html_e('Created', 'ifolders'); ?></th>
                            <th class="ifs-field-date"><?php esc_html_e('Modified', 'ifolders'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="ifs-can-select" al-repeat="group in App.data.groups.list" al-attr.class.ifs-selected="App.data.groups.selected == group.id" al-on.click.noprevent="App.fn.groups.select(group)" al-on.dblclick="App.fn.groups.dblclick(group)">
                            <td class="ifs-field-check"><input type="checkbox" al-checked="group.checked" al-on.change="App.fn.selectOne($event, group.checked, App.data.groups, App.scope)"></td>
                            <td class="ifs-field-text">{{group.title}}</td>
                            <td class="ifs-field-check ifs-readonly"><input type="checkbox" al-checked="group.enabled"></td>
                            <td class="ifs-field-check ifs-readonly"><input type="checkbox" al-checked="group.shared"></td>
                            <td class="ifs-field-date">{{group.created}}</td>
                            <td class="ifs-field-date">{{group.modified}}</td>
                        </tr>
                        <tr al-repeat="i in App.data.groups.view.absents">
                            <td class="ifs-field-check"></td>
                            <td class="ifs-field-text"></td>
                            <td class="ifs-field-check"></td>
                            <td class="ifs-field-check"></td>
                            <td class="ifs-field-date"></td>
                            <td class="ifs-field-date"></td>
                        </tr>
                        </tbody>
                        <tbody class="ifs-loader" al-attr.class.ifs-active="App.data.groups.loading"></tbody>
                    </table>
                    <h3><?php esc_html_e('Folder Types', 'ifolders'); ?></h3>
                    <p><?php esc_html_e('This section presents the types of folders (media, pages, posts, etc.) supported by the plugin. In order for a user to access these folders, you must add a group in which that user will have the specified rights. Simply double-click on the folder type and add the selected group. After this action the users of this group will have access to this folder type depends on their rights.', 'ifolders'); ?></p>
                    <div class="ifs-table-toolbar ifs-orange">
                        <div class="ifs-left-group">
                            <div class="ifs-btn" al-on.click="App.fn.foldertypes.add()" title="<?php esc_html_e('Add folder type', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 15 10 L 15 15 L 10 15 L 10 17 L 15 17 L 15 22 L 17 22 L 17 17 L 22 17 L 22 15 L 17 15 L 17 10 Z"/></svg>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.foldertypes.edit()" al-if="App.data.foldertypes.selected" title="<?php esc_html_e('Edit folder type', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 23.90625 3.96875 C 22.859375 3.96875 21.8125 4.375 21 5.1875 L 5.1875 21 L 5.125 21.3125 L 4.03125 26.8125 L 3.71875 28.28125 L 5.1875 27.96875 L 10.6875 26.875 L 11 26.8125 L 26.8125 11 C 28.4375 9.375 28.4375 6.8125 26.8125 5.1875 C 26 4.375 24.953125 3.96875 23.90625 3.96875 Z M 23.90625 5.875 C 24.410156 5.875 24.917969 6.105469 25.40625 6.59375 C 26.378906 7.566406 26.378906 8.621094 25.40625 9.59375 L 24.6875 10.28125 L 21.71875 7.3125 L 22.40625 6.59375 C 22.894531 6.105469 23.402344 5.875 23.90625 5.875 Z M 20.3125 8.71875 L 23.28125 11.6875 L 11.1875 23.78125 C 10.53125 22.5 9.5 21.46875 8.21875 20.8125 Z M 6.9375 22.4375 C 8.136719 22.921875 9.078125 23.863281 9.5625 25.0625 L 6.28125 25.71875 Z"/></svg>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.foldertypes.delete()" al-if="App.data.foldertypes.checked" title="<?php esc_html_e('Delete selected folder types', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"/></svg>
                            </div>
                        </div>
                        <div class="ifs-right-group">
                            <div class="ifs-group" al-if="App.data.foldertypes.view.total">
                                <div class="ifs-label">{{App.data.foldertypes.view.first}}-{{App.data.foldertypes.view.last}} of {{App.data.foldertypes.view.total}}</div>
                                <div class="ifs-btn" al-on.click="App.fn.foldertypes.load(App.data.foldertypes.view.page - 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 19.03125 4.28125 L 8.03125 15.28125 L 7.34375 16 L 8.03125 16.71875 L 19.03125 27.71875 L 20.46875 26.28125 L 10.1875 16 L 20.46875 5.71875 Z"/></svg>
                                </div>
                                <div class="ifs-btn" al-on.click="App.fn.foldertypes.load(App.data.foldertypes.view.page + 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 12.96875 4.28125 L 11.53125 5.71875 L 21.8125 16 L 11.53125 26.28125 L 12.96875 27.71875 L 23.96875 16.71875 L 24.65625 16 L 23.96875 15.28125 Z"/></svg>
                                </div>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.foldertypes.load()" title="<?php esc_html_e('Refresh', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 10.886719 4 6.617188 7.160156 4.875 11.625 L 6.71875 12.375 C 8.175781 8.640625 11.710938 6 16 6 C 19.242188 6 22.132813 7.589844 23.9375 10 L 20 10 L 20 12 L 27 12 L 27 5 L 25 5 L 25 8.09375 C 22.808594 5.582031 19.570313 4 16 4 Z M 25.28125 19.625 C 23.824219 23.359375 20.289063 26 16 26 C 12.722656 26 9.84375 24.386719 8.03125 22 L 12 22 L 12 20 L 5 20 L 5 27 L 7 27 L 7 23.90625 C 9.1875 26.386719 12.394531 28 16 28 C 21.113281 28 25.382813 24.839844 27.125 20.375 Z"/></svg>
                            </div>
                        </div>
                    </div>
                    <table class="ifs-table">
                        <thead>
                        <tr>
                            <th class="ifs-field-check"><input type="checkbox" al-checked="App.data.foldertypes.checked" al-on.change="App.fn.selectAll($event, App.data.foldertypes.checked, App.data.foldertypes, App.scope)">
                            <th class="ifs-field-text"><?php esc_html_e('Folder Type Name', 'ifolders'); ?></th>
                            <th class="ifs-field-text"><?php esc_html_e('Attached Groups', 'ifolders'); ?></th>
                            <th class="ifs-field-text"><?php esc_html_e('Enabled', 'ifolders'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="ifs-can-select" al-repeat="foldertype in App.data.foldertypes.list" al-attr.class.ifs-selected="App.data.foldertypes.selected == foldertype.type" al-on.click.noprevent="App.fn.foldertypes.select(foldertype)" al-on.dblclick="App.fn.foldertypes.dblclick(foldertype)">
                            <td class="ifs-field-check"><input type="checkbox" al-checked="foldertype.checked" al-on.change="App.fn.selectOne($event, foldertype.checked, App.data.foldertypes, App.scope)"></td>
                            <td class="ifs-field-text">{{foldertype.title}}</td>
                            <td class="ifs-field-text">{{foldertype.attached_groups}}</td>
                            <td class="ifs-field-check"><input type="checkbox" al-checked="foldertype.enabled" al-on.click.noprevent="App.fn.foldertypes.click($event, foldertype)"></td>
                        </tr>
                        <tr al-repeat="i in App.data.foldertypes.view.absents">
                            <td class="ifs-field-check"></td>
                            <td class="ifs-field-text"></td>
                            <td class="ifs-field-text"></td>
                            <td class="ifs-field-check"></td>
                        </tr>
                        </tbody>
                        <tbody class="ifs-loader" al-attr.class.ifs-active="App.data.foldertypes.loading"></tbody>
                    </table>
                    <h3><?php esc_html_e('Users Info', 'ifolders'); ?></h3>
                    <p><?php esc_html_e('This section shows brief information on users and their access to folders.', 'ifolders'); ?></p>
                    <div class="ifs-table-toolbar ifs-blue">
                        <div class="ifs-left-group">
                        </div>
                        <div class="ifs-right-group">
                            <div class="ifs-group" al-if="App.data.usersinfo.view.total">
                                <div class="ifs-label">{{App.data.usersinfo.view.first}}-{{App.data.usersinfo.view.last}} of {{App.data.usersinfo.view.total}}</div>
                                <div class="ifs-btn" al-on.click="App.fn.foldertypes.load(App.data.usersinfo.view.page - 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 19.03125 4.28125 L 8.03125 15.28125 L 7.34375 16 L 8.03125 16.71875 L 19.03125 27.71875 L 20.46875 26.28125 L 10.1875 16 L 20.46875 5.71875 Z"/></svg>
                                </div>
                                <div class="ifs-btn" al-on.click="App.fn.foldertypes.load(App.data.usersinfo.view.page + 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 12.96875 4.28125 L 11.53125 5.71875 L 21.8125 16 L 11.53125 26.28125 L 12.96875 27.71875 L 23.96875 16.71875 L 24.65625 16 L 23.96875 15.28125 Z"/></svg>
                                </div>
                            </div>
                            <div class="ifs-btn" al-on.click="App.fn.usersinfo.load()" title="<?php esc_html_e('Refresh', 'ifolders'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 10.886719 4 6.617188 7.160156 4.875 11.625 L 6.71875 12.375 C 8.175781 8.640625 11.710938 6 16 6 C 19.242188 6 22.132813 7.589844 23.9375 10 L 20 10 L 20 12 L 27 12 L 27 5 L 25 5 L 25 8.09375 C 22.808594 5.582031 19.570313 4 16 4 Z M 25.28125 19.625 C 23.824219 23.359375 20.289063 26 16 26 C 12.722656 26 9.84375 24.386719 8.03125 22 L 12 22 L 12 20 L 5 20 L 5 27 L 7 27 L 7 23.90625 C 9.1875 26.386719 12.394531 28 16 28 C 21.113281 28 25.382813 24.839844 27.125 20.375 Z"/></svg>
                            </div>
                        </div>
                    </div>
                    <table class="ifs-table">
                        <thead>
                        <tr>
                            <th class="ifs-field-text"><?php esc_html_e('User', 'ifolders'); ?></th>
                            <th class="ifs-field-text"><?php esc_html_e('Access To', 'ifolders'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr al-repeat="userinfo in App.data.usersinfo.list">
                            <td class="ifs-field-text">{{userinfo.name}}</td>
                            <td class="ifs-field-text">{{userinfo.access}}</td>
                        </tr>
                        <tr al-repeat="i in App.data.usersinfo.view.absents">
                            <td class="ifs-field-text"></td>
                            <td class="ifs-field-text"></td>
                        </tr>
                        </tbody>
                        <tbody class="ifs-loader" al-attr.class.ifs-active="App.data.usersinfo.loading"></tbody>
                    </table>
                </div>
                <div class="ifs-column-2 ifs-promo">
                </div>
            </div>
        </div>
        <div class="ifs-main-data" al-attr.class.ifs-active="App.ui.tabs.fn.is('data')">
            <div class="ifs-two-columns">
                <div class="ifs-column-1">
                    <h3><?php esc_html_e('All Folders', 'ifolders'); ?></h3>
                    <p><?php esc_html_e('Use this section to view all existed folders and delete them if it\'s needed, all sub folders are also will be deleted.', 'ifolders'); ?></p>
                    <p al-if="!App.data.folders.loaded"><?php esc_html_e('Loading data...', 'ifolders'); ?></p>
                    <div al-if="App.data.folders.loaded">
                        <div class="ifs-table-toolbar ifs-green">
                            <div class="ifs-left-group">
                                <div class="ifs-btn" al-on.click="App.fn.folders.delete('list')" al-if="App.data.folders.checked">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"/></svg>
                                </div>
                            </div>
                            <div class="ifs-right-group">
                                <div class="ifs-group" al-if="App.data.folders.view.total">
                                    <div class="ifs-label">{{App.data.folders.view.first}}-{{App.data.folders.view.last}} of {{App.data.folders.view.total}}</div>
                                    <div class="ifs-btn" al-on.click="App.fn.folders.load(App.data.folders.view.page - 1)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 19.03125 4.28125 L 8.03125 15.28125 L 7.34375 16 L 8.03125 16.71875 L 19.03125 27.71875 L 20.46875 26.28125 L 10.1875 16 L 20.46875 5.71875 Z"/></svg>
                                    </div>
                                    <div class="ifs-btn" al-on.click="App.fn.folders.load(App.data.folders.view.page + 1)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 12.96875 4.28125 L 11.53125 5.71875 L 21.8125 16 L 11.53125 26.28125 L 12.96875 27.71875 L 23.96875 16.71875 L 24.65625 16 L 23.96875 15.28125 Z"/></svg>
                                    </div>
                                </div>
                                <div class="ifs-btn" al-on.click="App.fn.folders.load()" title="<?php esc_html_e('Refresh', 'ifolders'); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 10.886719 4 6.617188 7.160156 4.875 11.625 L 6.71875 12.375 C 8.175781 8.640625 11.710938 6 16 6 C 19.242188 6 22.132813 7.589844 23.9375 10 L 20 10 L 20 12 L 27 12 L 27 5 L 25 5 L 25 8.09375 C 22.808594 5.582031 19.570313 4 16 4 Z M 25.28125 19.625 C 23.824219 23.359375 20.289063 26 16 26 C 12.722656 26 9.84375 24.386719 8.03125 22 L 12 22 L 12 20 L 5 20 L 5 27 L 7 27 L 7 23.90625 C 9.1875 26.386719 12.394531 28 16 28 C 21.113281 28 25.382813 24.839844 27.125 20.375 Z"/></svg>
                                </div>
                            </div>
                        </div>
                        <table class="ifs-table">
                        <thead>
                        <tr>
                            <th class="ifs-field-check"><input type="checkbox" al-checked="App.data.folders.checked" al-on.change="App.fn.selectAll($event, App.data.folders.checked, App.data.folders)"></th>
                            <th class="ifs-field-text"><?php esc_html_e('Folder Title', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'title')"></span></th>
                            <th class="ifs-field-text"><?php esc_html_e('Owner', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'owner')"></span></th>
                            <th class="ifs-field-text"><?php esc_html_e('Group', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'group_title')"></span></th>
                            <th class="ifs-field-text"><?php esc_html_e('Folder Type', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'type')"></span></th>
                            <th class="ifs-field-number"><?php esc_html_e('Attachments', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'attachments')"></span></th>
                            <th class="ifs-field-date"><?php esc_html_e('Created', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'created')"></span></th>
                            <th class="ifs-field-date"><?php esc_html_e('Modified', 'ifolders'); ?><span class="ifs-field-sort" al-on.click="App.fn.folders.sort($element, 'modified')"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr al-repeat="folder in App.data.folders.list">
                            <td class="ifs-field-check"><input type="checkbox" al-checked="folder.checked" al-on.change="App.fn.selectOne($event, folder.checked, App.data.folders)"></td>
                            <td class="ifs-field-text">{{folder.title}}</td>
                            <td class="ifs-field-text">{{folder.owner}}</td>
                            <td class="ifs-field-text">{{folder.group_title}}</td>
                            <td class="ifs-field-text">{{folder.type}}</td>
                            <td class="ifs-field-number">{{folder.attachments}}</td>
                            <td class="ifs-field-date">{{folder.created}}</td>
                            <td class="ifs-field-date">{{folder.modified}}</td>
                        </tr>
                        <tr al-repeat="i in App.data.folders.view.absents">
                            <td al-repeat="i in 8"></td>
                        </tr>
                        </tbody>
                        <tbody class="ifs-loader" al-attr.class.ifs-active="App.data.folders.loading"></tbody>
                    </table>
                        <br>
                        <div class="ifs-button ifs-warning" al-on.click="App.fn.folders.delete('all')"><?php esc_html_e('Delete All Folders', 'ifolders'); ?></div>
                    </div>
                </div>
                <div class="ifs-column-2 ifs-promo">
                </div>
            </div>
        </div>
    </div>
</div>