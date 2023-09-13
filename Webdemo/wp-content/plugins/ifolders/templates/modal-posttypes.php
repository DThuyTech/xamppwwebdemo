<?php
defined('ABSPATH') || exit;
?>
<div class="ifs-modal">
    <div class="ifs-dialog">
        <div class="ifs-header">
            <div class="ifs-title"><?php esc_html_e("Post Types", 'ifolders'); ?></div>
            <div class="ifs-cancel" al-on.click="Modal.fn.close()"></div>
        </div>
        <div class="ifs-data">
            <div class="ifs-loader" al-attr.class.ifs-active="Modal.loading"></div>
            <div al-if="Modal.data.posttypes.loaded">
                <table class="ifs-table" >
                    <tbody>
                    <tr class="ifs-can-select" al-repeat="posttype in Modal.data.posttypes.list" al-attr.class.ifs-selected="Modal.data.posttypes.selected == posttype.id" al-on.click.noprevent="Modal.fn.select(posttype)" al-on.dblclick="Modal.fn.dblclick(posttype)">
                        <td class="ifs-field-text">{{posttype.name}}</td>
                    </tr>
                    <tr al-repeat="i in Modal.data.posttypes.view.absents">
                        <td al-repeat="i in 1"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ifs-footer">
            <div class="ifs-btn ifs-cancel" al-on.click="Modal.fn.close()"><?php esc_html_e("Cancel", 'ifolders'); ?></div>
            <div class="ifs-btn ifs-submit" al-on.click="Modal.fn.submit()" al-if="Modal.data.posttypes.loaded"><?php esc_html_e("Submit", 'ifolders'); ?></div>
        </div>
    </div>
</div>
