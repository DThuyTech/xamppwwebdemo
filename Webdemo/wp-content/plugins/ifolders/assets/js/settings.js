!function(l){"use strict";const d={clone:a=>JSON.parse(JSON.stringify(a)),guid:()=>([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g,a=>(a^crypto.getRandomValues(new Uint8Array(1))[0]&15>>a/4).toString(16))},i={TABLE:{loading:!1,checked:!1,selected:null,list:[],view:{page:1,perpage:10,first:0,last:0,total:0,absents:0},order:{column:null,type:null}}},n={alight:null,scope:null,ui:{loader:{count:0,timerId:null,$container:null},lock:{$container:null},tabs:{list:["general","rights","data"],selected:0,fn:{is:a=>0<=n.ui.tabs.selected&&n.ui.tabs.selected<n.ui.tabs.list.length&&n.ui.tabs.list[n.ui.tabs.selected]===a,click:a=>{n.ui.tabs.selected=n.ui.tabs.list.indexOf(a)}}}},data:{code:null,ticket:null,roles:[],config:null,groups:d.clone(i.TABLE),foldertypes:d.clone(i.TABLE),usersinfo:d.clone(i.TABLE),folders:d.clone(i.TABLE)},default:{config:{roles:[],default_color:null,disable_counter:!1,disable_ajax:!1,infinite_scrolling:!1},group_right:{user_id:null,c:!0,v:!0,e:!0,d:!0,a:!0}},modal:{$container:null,templates:{},fn:{show:(o,e,t)=>{function s(a,e,t){e.guid=e.guid||d.guid();const s=l(a).attr({"data-modal-name":o,"data-modal-guid":e.guid});n.modal.$container.append(s),e.scope=n.alight(s.get(0),{App:n,Modal:e}),s.addClass("ifs-active"),t&&t.call(this)}n.modal.templates[o]?s(n.modal.templates[o],e,t):n.fn.loadTemplate(o).done(a=>{n.modal.templates[o]=a,s(n.modal.templates[o],e,t)}).fail(()=>{n.notify.show(n.globals.msg.failed,"ifs-failed")})},close:a=>{l(`[data-modal-guid='${a.guid}']`).removeClass("ifs-active").remove(),a.scope.destroy(),a.scope=null}}},fn:{init:()=>{n.globals=ifolders_settings_globals,n.notify=new IFOLDERS.PLUGINS.NOTIFY,n.colorpicker=new IFOLDERS.PLUGINS.COLORPICKER,n.fn.build(),n.data.groups.view.perpage=5,n.data.folders.view.perpage=20,n.fn.config.load(),n.fn.groups.load(),n.fn.foldertypes.load(),n.fn.usersinfo.load(),n.fn.folders.load(),n.fn.promo.load(),n.fn.ticket.load()},build:()=>{n.ui.lock.$container=l("#ifs-main-lock"),n.ui.loader.$container=l("#ifs-loader"),n.modal.$container=l("<div>").addClass("ifs-modals").attr({tabindex:-1}),l("body").append(n.modal.$container)},processData:(a,e)=>{const t=l.Deferred();a=JSON.stringify(a),n.fn.loading(!0),e=l.ajax({url:n.globals.ajax.url,type:"POST",dataType:"json",data:{nonce:n.globals.ajax.nonce,action:e,data:a}}).done(a=>{a?a.success?t.resolve(a.data):t.reject(a.data):t.reject()}).fail(()=>{t.reject()}).always(()=>{n.fn.loading(!1)});return{...t.promise(),abort:e.abort}},updateData:a=>n.fn.processData(a,n.globals.ajax.actions.update_data),getData:a=>n.fn.processData(a,n.globals.ajax.actions.get_data),loadTemplate:(a,e)=>{const t=l.Deferred();e||n.fn.loading(!0);a=l.ajax({url:n.globals.ajax.url,type:"POST",dataType:"json",data:{nonce:n.globals.ajax.nonce,action:n.globals.ajax.actions.get_template,template:a}}).done(function(a){a&&a.success?t.resolve(a.data):n.notify.show(n.globals.msg.failed,"ifs-failed")}).fail(function(){n.notify.show(n.globals.msg.failed,"ifs-failed"),t.resolve(null)}).always(function(){e||n.fn.loading(!1)});return{...t.promise(),abort:a.abort}},loading:a=>{n.ui.loader.count+=a?1:-1,n.ui.loader.count=n.ui.loader.count<0?0:n.ui.loader.count,clearTimeout(n.ui.loader.timerId),n.ui.loader.count?n.ui.loader.$container.toggleClass("ifs-active",!0):setTimeout(()=>{n.ui.loader.$container.toggleClass("ifs-active",!1)},300)},lock:a=>{n.ui.lock.$container.toggleClass("ifs-active",a)},getTableView:(a,e)=>({page:a.view.page,perpage:a.view.perpage,first:(a.view.page-1)*a.view.perpage+1,last:a.view.page*a.view.perpage-Math.max(a.view.perpage-a.list.length,0),total:e,absents:Math.max(a.view.perpage-a.list.length,0)}),selectOne:(a,e,t,s)=>{if(e)t.checked||(t.checked=e,(s||n.scope).scan());else{let a=!0;for(const o in t.list)if(t.list[o].checked){a=!1;break}a&&(t.checked=e,(s||n.scope).scan())}},selectAll:(a,e,t,s)=>{for(const o in t.list)t.list[o].checked=e;(s||n.scope).scan()},promo:{load:()=>{n.fn.loadTemplate("promo").done(t=>{l(".ifs-promo").each((a,e)=>{l(e).append(t),n.alight(e,n.scope)})})}},config:{load:()=>{n.fn.getData({target:"roles"}).done(a=>{n.data.roles=a.list,n.fn.getData({target:"config"}).done(a=>{if(n.data.config=l.extend(!0,{},n.default.config,a.config),n.data.config)for(var e in n.data.config)n.default.config.hasOwnProperty(e)||delete n.data.config[e];n.scope.scan();const t=l("#ifs-default-folder-color");n.colorpicker.set(t,n.data.config.default_color),t.on("color",n.fn.config.onColor),l("#ifs-app-settings").removeAttr("style")})})},onColor:(a,e)=>{n.data.config.default_color=e||null},onAccessRoleChange:(a,e)=>{var t=n.data.config.roles.indexOf(e.id);a.target.checked?-1===t&&n.data.config.roles.push(e.id):n.data.config.roles.splice(t,1)},isAccessRoleChecked:a=>-1!==n.data.config.roles.indexOf(a.id),save:()=>{n.data.ticket?(n.fn.loading(!0),n.fn.updateData({target:"config",config:n.data.config}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success")}).fail(()=>{n.notify.show(n.globals.msg.failed,"ifs-failed")}).always(()=>{n.fn.loading(!1)})):n.notify.show(n.globals.msg.upgrade,"ifs-upgrade")}},ticket:{load:()=>{n.fn.getData({target:"token"}).done(a=>{n.data.ticket=JSON.parse(atob(a.token)),n.data.ticket.supported_until=new Date(1e3*n.data.ticket.supported_until).toLocaleDateString(),n.scope.scan()})},activate:()=>{if(/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i.exec(l.trim(n.data.code))){let t={...JSON.parse(atob(n.globals.token)),code:n.data.code};var a=JSON.stringify({action:"activate",token:btoa(JSON.stringify(t))});n.fn.lock(!0),n.fn.loading(!0),l.ajax({url:n.globals.ajax.license_url,type:"POST",dataType:"json",contentType:"application/json",data:a}).done(a=>{var e;a&&a.success?(t={code:t.code,supported_until:a.data.supported_until,product:"iFolders Pro",site:t.site},e=btoa(JSON.stringify(t)),n.fn.loading(!0),n.fn.updateData({target:"token",action:"insert",token:e}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.ticket.load()}).fail(()=>{n.notify.show(n.globals.msg.status[407],"ifs-failed")}).always(()=>{n.fn.loading(!1)})):a.status&&n.globals.msg.status[a.status]?n.notify.show(n.globals.msg.status[a.status],"ifs-failed"):n.notify.show(n.globals.msg.failed,"ifs-failed")}).fail(()=>{n.notify.show(n.globals.msg.failed,"ifs-failed")}).always(()=>{n.fn.loading(!1),n.fn.lock(!1)})}else n.notify.show(n.globals.msg.status[404],"ifs-failed")},deactivate:()=>{var a;n.data.ticket&&n.data.ticket.code&&(a=JSON.stringify({action:"deactivate",code:n.data.ticket.code}),n.fn.lock(!0),n.fn.loading(!0),l.ajax({url:n.globals.ajax.license_url,type:"POST",dataType:"json",contentType:"application/json",data:a}).done(a=>{a&&a.success?(n.fn.loading(!0),n.fn.updateData({target:"token",action:"delete"}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.data.ticket=null,n.scope.scan()}).fail(()=>{n.notify.show(n.globals.msg.failed,"ifs-failed")}).always(()=>{n.fn.loading(!1)})):n.notify.show(n.globals.msg.failed,"ifs-failed")}).fail(()=>{n.notify.show(n.globals.msg.failed,"ifs-failed")}).always(()=>{n.fn.loading(!1),n.fn.lock(!1)}))}},groups:{load:e=>{function t(){n.fn.getData({target:"groups",type:"list",page:n.data.groups.view.page,itemsperpage:n.data.groups.view.perpage}).done(a=>{n.data.groups.loaded=!0,n.data.groups.loading=!1,n.data.groups.list=a.list.map(a=>({...a,checked:!1})),n.data.groups.view=n.fn.getTableView(n.data.groups,a.total),n.data.groups.checked=!1,n.data.groups.selected=null,n.scope.scan()})}n.data.groups.loading=!0,void 0!==e?n.fn.getData({target:"groups",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/n.data.groups.view.perpage)))!=n.data.groups.view.page?(n.data.groups.view.page=e,n.data.groups.view.total=a.total,t()):(n.data.groups.loading=!1,n.scope.scan())}):t()},select:a=>{n.data.groups.selected=n.data.groups.selected!==a.id?a.id:null},dblclick:a=>{n.data.groups.selected=a.id,n.fn.groups.edit()},add:()=>{const o={data:{title:null,enabled:!0,shared:!0,rights:d.clone(i.TABLE)},fn:{load:()=>{o.data.rights.loaded=!0,o.data.rights.view=n.fn.getTableView(o.data.rights,0),o.scope.scan()},loading:a=>{o.loading=a,o.scope.scan()},close:()=>{n.modal.fn.close(o)},submit:()=>{const a={title:o.data.title,enabled:o.data.enabled,shared:o.data.shared,rights:[]};for(const t in o.data.rights.list){var e=o.data.rights.list[t];a.rights.push({user_id:e.user_id,c:e.c,v:e.v,e:e.e,d:e.d,a:e.a})}o.fn.loading(!0),n.fn.updateData({target:"groups",action:"insert",data:a}).done(a=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.groups.load(),n.fn.usersinfo.load(),n.modal.fn.close(o)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),o.fn.loading(!1)})},rights:{delete:()=>{for(let a=o.data.rights.list.length-1;0<=a;a--)o.data.rights.list[a].checked&&o.data.rights.list.splice(a,1);o.data.rights.checked=!1,o.data.rights.view.absents=Math.max(o.data.rights.view.perpage-o.data.rights.list.length,0)},selectUsers:e=>{const s={data:{users:d.clone(i.TABLE)},fn:{load:e=>{function t(){s.fn.loading(!0),s.request=n.fn.getData({target:"users",data:"list",page:s.data.users.view.page,itemsperpage:s.data.users.view.perpage}).done(a=>{s.data.users.loaded=!0,s.data.users.list=a.list.map(a=>({...a,checked:!1})),s.data.users.view=n.fn.getTableView(s.data.users,a.total),s.data.users.checked=!1,s.scope.scan()}).always(()=>{s.request=null,s.fn.loading(!1)})}void 0!==e?(s.fn.loading(!0),n.fn.getData({target:"users",data:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/s.data.users.view.perpage)))!==s.data.users.view.page&&(s.data.users.view.page=e,s.data.users.view.total=a.total,s.request=null,t())}).always(()=>{s.request=null,s.fn.loading(!1)})):t()},loading:a=>{s.loading=a,s.scope.scan()},close:()=>{s.request&&s.request.abort(),n.modal.fn.close(s)},submit:()=>{var a=s.data.users.list.filter(a=>a.checked);e&&e.call(this,a),s.fn.close()},dblclick:a=>{a.checked=!0,s.fn.submit()}}};n.modal.fn.show("modal-users",s,s.fn.load)},addUsers:a=>{let e=0;for(const t in a){const s={...n.default.group_right,checked:!1};s.user_id=a[t].id,s.user=a[t].name,o.fn.rights.hasRight(s)||(o.data.rights.list.unshift(s),e++)}e&&(o.data.rights.view.absents=Math.max(o.data.rights.view.perpage-o.data.rights.list.length,0),o.scope.scan())},hasRight:a=>{for(const e in o.data.rights.list)if(o.data.rights.list[e].user_id===a.user_id)return!0;return!1}}}};n.modal.fn.show("modal-group",o,o.fn.load)},edit:()=>{const a=n.data.groups.selected,l={data:{id:a,title:null,enabled:!0,shared:!0,rights:d.clone(i.TABLE)},fn:{load:()=>{l.fn.loading(!0),l.request=n.fn.getData({target:"groups",type:"item",id:a}).done(a=>{l.data.title=a.item.title,l.data.enabled=a.item.enabled,l.data.shared=a.item.shared,l.data.rights.loaded=!0,l.data.rights.list=a.item.rights.map(a=>({...a,checked:!1})),l.data.rights.view=n.fn.getTableView(l.data.rights,0),l.scope.scan()}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed")}).always(()=>{l.request=null,l.fn.loading(!1)})},loading:a=>{l.loading=a,l.scope.scan()},close:()=>{n.modal.fn.close(l)},submit:()=>{const a={id:l.data.id,title:l.data.title,enabled:l.data.enabled,shared:l.data.shared,rights:[]};for(const t in l.data.rights.list){var e=l.data.rights.list[t];a.rights.push({user_id:e.user_id,c:e.c,v:e.v,e:e.e,d:e.d,a:e.a})}l.fn.loading(!0),n.fn.updateData({target:"groups",action:"update",data:a}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.groups.load(),n.fn.usersinfo.load()}).always(()=>{l.fn.loading(!1),n.modal.fn.close(l)})},rights:{delete:()=>{for(let a=l.data.rights.list.length-1;0<=a;a--)l.data.rights.list[a].checked&&l.data.rights.list.splice(a,1);l.data.rights.checked=!1,l.data.rights.view.absents=Math.max(l.data.rights.view.perpage-l.data.rights.list.length,0)},selectUsers:e=>{const s={data:{users:d.clone(i.TABLE)},fn:{load:e=>{function t(){s.fn.loading(!0),s.request=n.fn.getData({target:"users",data:"list",page:s.data.users.view.page,itemsperpage:s.data.users.view.perpage}).done(a=>{s.data.users.loaded=!0,s.data.users.list=a.list.map(a=>({...a,checked:!1})),s.data.users.view=n.fn.getTableView(s.data.users,a.total),s.data.users.checked=!1,s.scope.scan()}).always(()=>{s.request=null,s.fn.loading(!1)})}void 0!==e?(s.fn.loading(!0),n.fn.getData({target:"users",data:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/s.data.users.view.perpage)))!==s.data.users.view.page&&(s.data.users.view.page=e,s.data.users.view.total=a.total,s.request=null,t())}).always(()=>{s.request=null,s.fn.loading(!1)})):t()},loading:a=>{s.loading=a,s.scope.scan()},close:()=>{s.request&&s.request.abort(),n.modal.fn.close(s)},submit:()=>{var a=s.data.users.list.filter(a=>a.checked);e&&e.call(this,a),s.fn.close()},dblclick:a=>{a.checked=!0,s.fn.submit()}}};n.modal.fn.show("modal-users",s,s.fn.load)},addUsers:a=>{let e=0;for(const s in a){var t=a[s];const o={...n.default.group_right,checked:!1};o.user_id=t.id,o.user=t.name,l.fn.rights.hasRight(o)||(l.data.rights.list.unshift(o),e++)}e&&(l.data.rights.view.absents=Math.max(l.data.rights.view.perpage-l.data.rights.list.length,0),l.scope.scan())},hasRight:a=>{for(const e in l.data.rights.list)if(l.data.rights.list[e].user_id===a.user_id)return!0;return!1}}}};n.modal.fn.show("modal-group",l,l.fn.load)},delete:()=>{const a=n.data.groups.list.filter(a=>a.checked).map(a=>a.id),e={data:{count:a.length},fn:{loading:a=>{e.loading=a,e.scope.scan()},close:()=>{n.modal.fn.close(e)},submit:()=>{e.fn.loading(!0),n.fn.updateData({target:"groups",action:"delete",type:"list",list:a}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.groups.load(),n.fn.folders.load(),n.fn.foldertypes.load(),n.fn.usersinfo.load(),n.modal.fn.close(e)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),e.fn.loading(!1)})}}};n.modal.fn.show("modal-confirm-delete",e)}},foldertypes:{load:e=>{function t(){n.data.foldertypes.loading=!0,n.fn.getData({target:"foldertypes",type:"list",page:n.data.foldertypes.view.page,itemsperpage:n.data.foldertypes.view.perpage}).done(a=>{n.data.foldertypes.loading=!1,n.data.foldertypes.list=a.list.map(a=>({...a,checked:!1})),n.data.foldertypes.view=n.fn.getTableView(n.data.foldertypes,a.total),n.data.foldertypes.checked=!1,n.data.foldertypes.selected=null,n.scope.scan()})}void 0!==e?n.fn.getData({target:"foldertypes",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/n.data.foldertypes.view.perpage)))!=n.data.foldertypes.view.page&&(n.data.foldertypes.view.page=e,n.data.foldertypes.view.total=a.total,t())}):t()},select:a=>{n.data.foldertypes.selected=n.data.foldertypes.selected!==a.type?a.type:null},click:(a,e)=>{n.data.ticket?(e={type:e.type,enabled:!e.enabled},n.fn.loading(!0),n.fn.updateData({target:"foldertypes",action:"update",type:"state",data:e}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.usersinfo.load()}).always(()=>{n.fn.loading(!1)})):(n.notify.show(n.globals.msg.upgrade,"ifs-upgrade"),a.preventDefault())},dblclick:a=>{n.data.foldertypes.selected=a.type,n.fn.foldertypes.edit()},add:()=>{n.fn.posttypes.select(function(a){const o={data:{type:a,title:a,enabled:!0,predefined:!1,groups:d.clone(i.TABLE)},fn:{load:()=>{o.data.groups.loaded=!0,o.data.groups.view=n.fn.getTableView(o.data.groups,0),o.scope.scan()},loading:a=>{o.loading=a,o.scope.scan()},close:()=>{n.modal.fn.close(o)},submit:()=>{if(n.data.ticket){const e={type:o.data.type,title:o.data.title,enabled:o.data.enabled,groups:[]};for(const t in o.data.groups.list){var a=o.data.groups.list[t];e.groups.push({id:a.id})}n.fn.updateData({target:"foldertypes",action:"insert",data:e}).done(a=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.foldertypes.load(),n.fn.usersinfo.load(),n.modal.fn.close(o)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),o.fn.loading(!1)})}else n.notify.show(n.globals.msg.upgrade,"ifs-upgrade")},changeType:a=>{o.data.type=a,o.scope.scan()},groups:{delete:()=>{for(let a=o.data.groups.list.length-1;0<=a;a--)o.data.groups.list[a].checked&&o.data.groups.list.splice(a,1);o.data.groups.checked=!1,o.data.groups.view.absents=Math.max(o.data.groups.view.perpage-o.data.groups.list.length,0)},selectGroups:e=>{const s={data:{groups:d.clone(i.TABLE)},fn:{load:e=>{function t(){s.fn.loading(!0),s.request=n.fn.getData({target:"groups",type:"list",page:s.data.groups.view.page,itemsperpage:s.data.groups.view.perpage}).done(a=>{s.data.groups.loaded=!0,s.data.groups.list=a.list.map(a=>({...a,checked:!1})),s.data.groups.view=n.fn.getTableView(s.data.groups,a.total),s.data.groups.checked=!1,s.scope.scan()}).always(()=>{s.request=null,s.fn.loading(!1)})}void 0!==e?(s.fn.loading(!0),n.fn.getData({target:"groups",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/s.data.groups.view.perpage)))!==s.data.groups.view.page&&(s.data.groups.view.page=e,s.data.groups.view.total=a.total,t())}).always(()=>{s.fn.loading(!1)})):t()},loading:a=>{s.loading=a,s.scope.scan()},close:()=>{s.request&&s.request.abort(),n.modal.fn.close(s)},submit:()=>{var a=s.data.groups.list.filter(a=>a.checked);e&&e.call(this,a),s.fn.close()},dblclick:a=>{a.checked=!0,s.fn.submit()}}};n.modal.fn.show("modal-groups",s,s.fn.load)},addGroups:a=>{let e=0;for(const t in a){const s={id:null,title:null,checked:!1};s.id=a[t].id,s.title=a[t].title,o.fn.groups.hasGroup(s)||(o.data.groups.list.unshift(s),e++),e&&(o.data.groups.view.absents=Math.max(o.data.groups.view.perpage-o.data.groups.list.length,0),o.scope.scan())}},hasGroup:a=>{for(const e in o.data.groups.list)if(o.data.groups.list[e].id===a.id)return!0;return!1}}}};n.modal.fn.show("modal-foldertype",o,o.fn.load)})},edit:()=>{const a=n.data.foldertypes.selected,o={data:{type_before:a,type:a,title:null,enabled:!0,predefined:!1,groups:d.clone(i.TABLE)},fn:{load:()=>{o.fn.loading(!0),o.request=n.fn.getData({target:"foldertypes",type:"item",id:a}).done(a=>{o.data.title=a.item.title,o.data.enabled=a.item.enabled,o.data.predefined=a.item.predefined,o.data.groups.loaded=!0,o.data.groups.list=a.item.groups.map(a=>({...a,checked:!1})),o.data.groups.view=n.fn.getTableView(o.data.groups,0),o.scope.scan()}).always(()=>{o.request=null,o.fn.loading(!1)})},loading:a=>{o.loading=a,o.scope.scan()},close:()=>{n.modal.fn.close(o)},submit:()=>{if(n.data.ticket||"attachment"==o.data.type||"page"==o.data.type){const e={type_before:o.data.type_before,type:o.data.type,title:o.data.title,enabled:o.data.enabled,groups:[]};for(const t in o.data.groups.list){var a=o.data.groups.list[t];e.groups.push({id:a.id})}o.fn.loading(!0),n.fn.updateData({target:"foldertypes",action:"update",type:"item",data:e}).done(a=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.foldertypes.load(),n.fn.usersinfo.load(),n.fn.folders.load(),n.modal.fn.close(o)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),o.fn.loading(!1)})}else n.notify.show(n.globals.msg.upgrade,"ifs-upgrade")},changeType:a=>{o.data.type=a,o.scope.scan()},groups:{delete:()=>{for(let a=o.data.groups.list.length-1;0<=a;a--)o.data.groups.list[a].checked&&o.data.groups.list.splice(a,1);o.data.groups.checked=!1,o.data.groups.view.absents=Math.max(o.data.groups.view.perpage-o.data.groups.list.length,0)},selectGroups:e=>{const s={data:{groups:d.clone(i.TABLE)},fn:{load:e=>{function t(){s.fn.loading(!0),s.request=n.fn.getData({target:"groups",type:"list",page:s.data.groups.view.page,itemsperpage:s.data.groups.view.perpage}).done(a=>{s.data.groups.loaded=!0,s.data.groups.list=a.list.map(a=>({...a,checked:!1})),s.data.groups.view=n.fn.getTableView(s.data.groups,a.total),s.data.groups.checked=!1,s.scope.scan()}).always(()=>{s.request=null,s.fn.loading(!1)})}void 0!==e?(s.fn.loading(!0),n.fn.getData({target:"groups",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/s.data.groups.view.perpage)))!==s.data.groups.view.page&&(s.data.groups.view.page=e,s.data.groups.view.total=a.total,t())}).always(()=>{s.fn.loading(!1)})):t()},loading:a=>{s.loading=a,s.scope.scan()},close:()=>{s.request&&s.request.abort(),n.modal.fn.close(s)},submit:()=>{var a=s.data.groups.list.filter(a=>a.checked);e&&e.call(this,a),s.fn.close()},dblclick:a=>{a.checked=!0,s.fn.submit()}}};n.modal.fn.show("modal-groups",s,s.fn.load)},addGroups:a=>{let e=0;for(const t in a){const s={id:null,title:null,checked:!1};s.id=a[t].id,s.title=a[t].title,o.fn.groups.hasGroup(s)||(o.data.groups.list.unshift(s),e++),e&&(o.data.groups.view.absents=Math.max(o.data.groups.view.perpage-o.data.groups.list.length,0),o.scope.scan())}},hasGroup:a=>{for(const e in o.data.groups.list)if(o.data.groups.list[e].id===a.id)return!0;return!1}}}};n.modal.fn.show("modal-foldertype",o,o.fn.load)},delete:()=>{const a=n.data.foldertypes.list.filter(a=>a.checked).map(a=>a.type),e={data:{count:a.length},fn:{loading:a=>{e.loading=a,e.scope.scan()},close:()=>{n.modal.fn.close(e)},submit:()=>{e.fn.loading(!0),n.fn.updateData({target:"foldertypes",action:"delete",type:"list",list:a}).done(a=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.groups.load(),n.fn.foldertypes.load(),n.fn.usersinfo.load(),n.fn.folders.load(),n.modal.fn.close(e)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),e.fn.loading(!1)})}}};a.length&&n.modal.fn.show("modal-confirm-delete",e)}},posttypes:{select:e=>{const t={data:{posttypes:d.clone(i.TABLE)},fn:{load:()=>{t.fn.loading(!0),t.request=n.fn.getData({target:"posttypes"}).done(a=>{t.data.posttypes.loaded=!0,t.data.posttypes.list=a.list,t.data.posttypes.view.page=1,t.data.posttypes.view.perpage=a.list.length<5?5:a.list.length,t.data.posttypes.view.absents=5,t.data.posttypes.view=n.fn.getTableView(t.data.posttypes,a.list.length),t.data.posttypes.checked=!1,t.scope.scan()}).always(()=>{t.request=null,t.fn.loading(!1)})},loading:a=>{t.loading=a,t.scope.scan()},close:()=>{t.request&&t.request.abort(),n.modal.fn.close(t)},submit:()=>{var a=t.data.posttypes.selected;a&&e&&e.call(this,a),t.fn.close()},select:a=>{t.data.posttypes.selected=t.data.posttypes.selected!==a.id?a.id:null},dblclick:a=>{t.fn.select(a),t.fn.submit()}}};n.modal.fn.show("modal-posttypes",t,t.fn.load)}},usersinfo:{load:e=>{function t(){n.data.usersinfo.loading=!0,n.fn.getData({target:"usersinfo",type:"list",page:n.data.usersinfo.view.page,itemsperpage:n.data.usersinfo.view.perpage}).done(a=>{n.data.usersinfo.loading=!1,n.data.usersinfo.list=a.list.map(a=>({...a,checked:!1})),n.data.usersinfo.view=n.fn.getTableView(n.data.usersinfo,a.total),n.data.usersinfo.checked=!1,n.data.usersinfo.selected=null,n.scope.scan()})}void 0!==e?n.fn.getData({target:"usersinfo",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/n.data.usersinfo.view.perpage)))!=n.data.usersinfo.view.page&&(n.data.usersinfo.view.page=e,n.data.usersinfo.view.total=a.total,t())}):t()}},folders:{load:e=>{function t(){n.fn.getData({target:"folders",type:"list",page:n.data.folders.view.page,itemsperpage:n.data.folders.view.perpage,order:n.data.folders.order}).done(a=>{n.data.folders.loaded=!0,n.data.folders.loading=!1,n.data.folders.list=a.list.map(a=>({...a,checked:!1})),n.data.folders.view=n.fn.getTableView(n.data.folders,a.total),n.data.folders.checked=!1,n.scope.scan()})}n.data.folders.loading=!0,void 0!==e?n.fn.getData({target:"folders",type:"total"}).done(a=>{(e=Math.min(Math.max(e,1),Math.ceil(a.total/n.data.folders.view.perpage)))!=n.data.folders.view.page?(n.data.folders.view.page=e,n.data.folders.view.total=a.total,t()):(n.data.folders.loading=!1,n.scope.scan())}):t()},delete:a=>{const e=n.data.folders.list.filter(a=>a.checked).map(a=>a.id),t={data:{count:"list"===a?e.length:n.data.folders.view.total},fn:{loading:a=>{t.loading=a,t.scope.scan()},close:()=>{n.modal.fn.close(t)},submit:()=>{t.fn.loading(!0),n.fn.updateData({target:"folders",action:"delete",type:a,list:e}).done(()=>{n.notify.show(n.globals.msg.success,"ifs-success"),n.fn.folders.load(),n.modal.fn.close(t)}).fail(a=>{a&&a.msg&&n.notify.show(a.msg,"ifs-failed"),t.fn.loading(!1)})}}};n.modal.fn.show("modal-confirm-delete",t)},sort:(a,e)=>{const t=l(a),s=t.closest("tr");switch(s.find(".ifs-field-sort").removeClass("ifs-field-sort-asc ifs-field-sort-desc"),n.data.folders.order.type=n.data.folders.order.column!==e||"asc"===n.data.folders.order.type?"desc":"asc",n.data.folders.order.column=e,n.data.folders.order.type){case"asc":t.removeClass("ifs-field-sort-desc").addClass("ifs-field-sort-asc");break;case"desc":t.removeClass("ifs-field-sort-asc").addClass("ifs-field-sort-desc")}n.fn.folders.load()}}}};window.alightInitCallback=function(a){delete window.alightInitCallback,n.config=l.extend(!0,{},n.default.config),n.license=l.extend(!0,{},n.default.license),n.alight=a,n.scope=n.alight(document.querySelectorAll("#ifs-app-settings")[0],{App:n}),n.fn.init()}}(jQuery);