YUI.add("moodle-block_navigation-navigation",function(e,t){e.Event.define("actionkey",{_event:e.UA.webkit||e.UA.ie?"keydown":"keypress",_keys:{37:"collapse",39:"expand",32:"toggle",13:"enter"},_keyHandler:function(e,t,n){var r;n.actions?r=n.actions:r={collapse:!0,expand:!0,toggle:!0,enter:!0},this._keys[e.keyCode]&&r[this._keys[e.keyCode]]&&(e.action=this._keys[e.keyCode],t.fire(e))},on:function(e,t,n){t.args===null?t._detacher=e.on(this._event,this._keyHandler,this,n,{actions:!1}):t._detacher=e.on(this._event,this._keyHandler,this,n,t.args[0])},detach:function(e,t){t._detacher.detach()},delegate:function(e,t,n,r){t.args===null?t._delegateDetacher=e.delegate(this._event,this._keyHandler,r,this,n,{actions:!1}):t._delegateDetacher=e.delegate(this._event,this._keyHandler,r,this,n,t.args[0])},detachDelegate:function(e,t){t._delegateDetacher.detach()}});var n=0,r=40,i={ROOTNODE:0,SYSTEM:1,CATEGORY:10,MYCATEGORY:11,COURSE:20,SECTION:30,ACTIVITY:40,RESOURCE:50,CUSTOM:60,SETTING:70,USER:80,CONTAINER:90},s=function(){s.superclass.constructor.apply(this,arguments)};s.prototype={id:null,branches:[],initializer:function(t){this.id=t.id;var n=e.one("#inst"+t.id);if(n===null)return;e.delegate("click",this.toggleExpansion,n.one(".block_tree"),".tree_item.branch",this),e.delegate("actionkey",this.toggleExpansion,n.one(".block_tree"),".tree_item.branch",this);var r=[];t.expansions?r=t.expansions:window["navtreeexpansions"+t.id]&&(r=window["navtreeexpansions"+t.id]);for(var i in r){var s=(new BRANCH({tree:this,branchobj:r[i],overrides:{expandable:!0,children:[],haschildren:!0}})).wire();M.block_navigation.expandablebranchcount++,this.branches[s.get("id")]=s}M.block_navigation.expandablebranchcount>0&&(e.delegate("click",this.fire_branch_action,n.one(".block_tree"),".tree_item.branch[data-expandable]",this),e.delegate("actionkey",this.fire_branch_action,n.one(".block_tree"),".tree_item.branch[data-expandable]",this)),this.get("candock")&&this.initialise_block(e,n)},fire_branch_action:function(e){var t=e.currentTarget.getAttribute("id"),n=this.branches[t];n.ajaxLoad(e)},toggleExpansion:function(e){if(!(!e.target.test("a")||e.keyCode!==0&&e.keyCode!==13)){e.stopPropagation();return}var t=e.target;t.test("li")||(t=t.ancestor("li"));if(!t)return;if(!t.hasClass("depth_1"))if(e.type==="actionkey"){switch(e.action){case"expand":t.removeClass("collapsed"),t.set("aria-expanded",!0);break;case"collapse":t.addClass("collapsed"),t.set("aria-expanded",!1);break;default:t.toggleClass("collapsed"),t.set("aria-expanded",!t.hasClass("collapsed"))}e.halt()}else t.toggleClass("collapsed"),t.set("aria-expanded",!t.hasClass("collapsed"));this.get("accordian")&&t.siblings("li").each(function(){this.get("id")!==t.get("id")&&!this.hasClass("collapsed")&&(this.addClass("collapsed"),this.set("aria-expanded",!1))});if(this.get("candock")){M.core_dock.resize();var n=M.core_dock.getPanel();n.visible&&n.correctWidth()}}},e.extend(s,e.Base,s.prototype,{NAME:"navigation-tree",ATTRS:{instance:{value:null},candock:{validator:e.Lang.isBool,value:!1},accordian:{validator:e.Lang.isBool,value:!1},expansionlimit:{value:0,setter:function(e){return parseInt(e,10)}}}}),M.core_dock&&M.core_dock.genericblock&&e.augment(s,M.core_dock.genericblock),BRANCH=function(){BRANCH.superclass.constructor.apply(this,arguments)},BRANCH.prototype={node:null,initializer:function(t){var i,s;if(t.branchobj!==null){for(i in t.branchobj)this.set(i,t.branchobj[i]);s=this.get("children"),this.set("haschildren",s.length>0)}if(t.overrides!==null)for(i in t.overrides)this.set(i,t.overrides[i]);this.node=e.one("#",this.get("id"));var o=this.get("tree").get("expansionlimit"),u=this.get("type");o!==n&&u>=o&&u<=r&&(this.set("expandable",!1),this.set("haschildren",!1))},draw:function(t){var n=this.get("expandable")||this.get("haschildren"),r=e.Node.create("<li></li>"),s=this.get("link"),o=e.Node.create('<p class="tree_item"></p>').setAttribute("id",this.get("id"));s||o.setAttribute("tabindex","0"),n&&(r.addClass("collapsed").addClass("contains_branch"),r.set("aria-expanded",!1),o.addClass("branch"));var u=!1,a=this.get("icon");if(a&&(!n||this.get("type")==i.ACTIVITY)){u=e.Node.create('<img alt="" />'),u.setAttribute("src",M.util.image_url(a.pix,a.component)),r.addClass("item_with_icon"),a.alt&&u.setAttribute("alt",a.alt),a.title&&u.setAttribute("title",a.title);if(a.classes)for(var f in a.classes)u.addClass(a.classes[f])}if(!s){var l=e.Node.create("<span></span>");u&&l.appendChild(u),l.append(this.get("name")),this.get("hidden")&&l.addClass("dimmed_text"),o.appendChild(l)}else{var c=e.Node.create('<a title="'+this.get("title")+'" href="'+s+'"></a>');u&&c.appendChild(u),c.append(this.get("name")),this.get("hidden")&&c.addClass("dimmed"),o.appendChild(c)}return r.appendChild(o),t.appendChild(r),this.node=o,this},wire:function(){return this.node=this.node||e.one("#"+this.get("id")),this.node?(this.get("expandable")&&(this.node.setAttribute("data-expandable","1"),this.node.setAttribute("data-loaded","0")),this):!1},getChildrenUL:function(){var t=this.node.next("ul");return t||(t=e.Node.create("<ul></ul>"),this.node.ancestor().append(t)),t},ajaxLoad:function(t){t.type==="actionkey"&&t.action!=="enter"?t.halt():t.stopPropagation();if(t.type==="actionkey"&&t.action==="enter"&&t.target.test("A"))return this.node.setAttribute("data-expandable","0"),this.node.setAttribute("data-loaded","1"),!0;if(this.node.hasClass("loadingbranch"))return!0;if(this.node.getAttribute("data-loaded")==="1")return!0;this.node.addClass("loadingbranch");var n={elementid:this.get("id"),id:this.get("key"),type:this.get("type"),sesskey:M.cfg.sesskey,instance:this.get("tree").get("instance")};return e.io(M.cfg.wwwroot+"/lib/ajax/getnavbranch.php",{method:"POST",data:build_querystring(n),on:{complete:this.ajaxProcessResponse},context:this}),!0},ajaxProcessResponse:function(t,n){this.node.removeClass("loadingbranch"),this.node.setAttribute("data-loaded","1");try{var r=e.JSON.parse(n.responseText);if(r.children&&r.children
.length>0){var s=0;for(var o in r.children)typeof r.children[o]=="object"&&(r.children[o].type==i.COURSE&&s++,this.addChild(r.children[o]));return(this.get("type")==i.CATEGORY||this.get("type")==i.ROOTNODE||this.get("type")==i.MYCATEGORY)&&s>=M.block_navigation.courselimit&&this.addViewAllCoursesChild(this),!0}}catch(u){}return this.node.replaceClass("branch","emptybranch"),!0},addChild:function(e){var t=new BRANCH({tree:this.get("tree"),branchobj:e});if(t.draw(this.getChildrenUL())){this.get("tree").branches[t.get("id")]=t,t.wire();var n=0,r,s=t.get("children");for(r in s)s[r].type==i.COURSE&&n++,typeof s[r]=="object"&&t.addChild(s[r]);(t.get("type")==i.CATEGORY||t.get("type")==i.MYCATEGORY)&&n>=M.block_navigation.courselimit&&this.addViewAllCoursesChild(t)}return!0},addViewAllCoursesChild:function(e){var t=null;e.get("type")==i.ROOTNODE?e.get("key")==="mycourses"?t=M.cfg.wwwroot+"/my":t=M.cfg.wwwroot+"/course/index.php":t=M.cfg.wwwroot+"/course/category.php?id="+e.get("key"),e.addChild({name:M.str.moodle.viewallcourses,title:M.str.moodle.viewallcourses,link:t,haschildren:!1,icon:{pix:"i/navigationitem",component:"moodle"}})}},e.extend(BRANCH,e.Base,BRANCH.prototype,{NAME:"navigation-branch",ATTRS:{tree:{validator:e.Lang.isObject},name:{value:"",validator:e.Lang.isString,setter:function(e){return e.replace(/\n/g,"<br />")}},title:{value:"",validator:e.Lang.isString},id:{value:"",validator:e.Lang.isString,getter:function(e){return e===""&&(e="expandable_branch_"+M.block_navigation.expandablebranchcount,M.block_navigation.expandablebranchcount++),e}},key:{value:null},type:{value:null},link:{value:!1},icon:{value:!1,validator:e.Lang.isObject},expandable:{value:!1,validator:e.Lang.isBool},hidden:{value:!1,validator:e.Lang.isBool},haschildren:{value:!1,validator:e.Lang.isBool},children:{value:[],validator:e.Lang.isArray}}}),M.block_navigation=M.block_navigation||{expandablebranchcount:1,courselimit:20,instance:null,init_add_tree:function(t){t.courselimit&&(this.courselimit=t.courselimit),M.core_dock&&M.core_dock.init(e),new s(t)}}},"@VERSION@",{requires:["base","core_dock","io-base","node","dom","event-custom","event-delegate","json-parse"]});