@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/nestable/jquery.nestable.css">
@endsection
@section('content')
    <div class="admin-content" id="app">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">菜单与权限</strong> /
                <small>Menus & Permissions</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" v-on:click="createParentPermission">
                            <span class="am-icon-plus"></span> 新增顶级菜单
                        </button>
                        <button type="button" class="am-btn am-btn-secondary" v-on:click="compress">
                            <span class="am-icon-compress"></span> 折叠
                        </button>
                        <button type="button" class="am-btn am-btn-success" v-on:click="expand">
                            <span class="am-icon-expand"></span> 展开
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-lg-6">

                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <li class="dd-item dd3-item" v-for="permission in permissions" :data-id="permission.id">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">
                                <span :class="permission.icon"></span> @{{permission.label}} (@{{permission.name}})
                                <div class="pull-right action-buttons">
                                    <a href="javascript:;" v-on:click="createPermission(permission.id)"><i class="am-icon-plus"></i></a>
                                    <a href="javascript:;" v-on:click="editPermission(permission.id)"><i class="am-icon-pencil"></i></a>
                                    <a href="javascript:;" v-on:click="destroyPermission(permission.id)"><i class="am-icon-trash"></i></a>
                                </div>
                            </div>

                            <ol class="dd-list dd-hide" data-start-collapsed="true" v-if="permission.children != ''">
                                <li class="dd-item dd3-item" :data-id="children.id" v-for="children in permission.children">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">
                                        <span :class="children.icon"></span> @{{children.label}} (@{{children.name}})
                                        <div class="pull-right action-buttons">
                                            <a href="javascript:;" v-on:click="createPermission(children.id)"><i class="am-icon-plus"></i></a>
                                            <a href="javascript:;" v-on:click="editPermission(children.id)"><i class="am-icon-pencil"></i></a>
                                            <a href="javascript:;" v-on:click="destroyPermission(children.id)"><i class="am-icon-trash"></i></a>
                                        </div>
                                    </div>

                                    <ol class="dd-list dd-hide" data-start-collapsed="true" v-if="children.children != ''">
                                        <li class="dd-item dd3-item" :data-id="c.id" v-for="c in children.children">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">
                                                @{{c.label}} (@{{c.name}})
                                                <div class="pull-right action-buttons">
                                                    <a href="javascript:;" v-on:click="editPermission(c.id)"><i class="am-icon-pencil"></i></a>
                                                    <a href="javascript:;" v-on:click="destroyPermission(c.id)"><i class="am-icon-trash"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="am-u-lg-6">
                <div class="am-panel am-panel-default">
                    <div class="am-panel-bd ">
                        <form class="am-form" v-on:submit.prevent="onSubmit" data-am-validator>
                            {{ csrf_field() }}
                            <div id="_method"></div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    上级菜单
                                </div>
                                <div class="am-u-sm-8 am-u-md-10">
                                    <select v-model="permission.parent_id">
                                        <option value="0">顶级菜单</option>

                                        <template v-for="permission in permissions">
                                            <option v-bind:value="permission.id">@{{permission.label}}</option>
                                            <template v-for="children in permission.children">
                                                <option v-bind:value="children.id">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@{{children.label}}</option>
                                            </template>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    图标
                                </div>
                                <div class="am-u-sm-8 am-u-md-10">
                                    <div class="am-form-group am-form-icon">
                                        <i :class="permission.icon"></i>
                                        <input type="text" class="am-form-field am-input-sm" v-model="permission.icon" placeholder="请输入图标的class">
                                    </div>
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    菜单名称
                                </div>
                                <div class="am-u-sm-8 am-u-md-10">
                                    <input type="text" class="am-input-sm" v-model="permission.label" id="label" placeholder="请输入菜单名称" required>
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                    权限名称
                                </div>
                                <div class="am-u-sm-8 am-u-md-10">
                                    <textarea rows="4" v-model="permission.name" id="name" placeholder="请输入权限名称" required></textarea>
                                </div>
                            </div>

                            <div class="am-margin">
                                <button type="submit" class="am-btn am-btn-primary am-radius">保 存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/vendor/nestable/jquery.nestable.js"></script>
    <script src="/vendor/vue/vue.js"></script>
    <script src="/vendor/vue/vue-resource.min.js"></script>
    <script>
        //排序
        $(function () {
            $('.dd').nestable({
                maxDepth: 3,
            }).on('change', function () {
                var sort_order = window.JSON.stringify($('#nestable').nestable('serialize'));

                $.ajax({
                    type: 'PATCH',
                    url: '/system/permission/sort_order',
                    data: {
                        sort_order: sort_order
                    },

                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                    }
                });
            });
        });

        Vue.use(VueResource);
        Vue.http.interceptors.push((request, next) => {
            request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
            next();
        });

        var app = new Vue({
            el: '#app',
            data: {
                permissions: {!! $permissions !!},
                permission: {
                    parent_id: 0,
                    icon: '',
                    label: '',
                    name: ''
                },
                form_type: 'post',
            },
            methods: {
                //展开
                compress: function () {
                    $('.dd').nestable('collapseAll');
                },
                //折叠
                expand: function () {
                    $('.dd').nestable('expandAll');
                },
                //重置当前编辑或修改的permission
                resetPermission: function () {
                    this.permission = {
                        parent_id: 0,
                        icon: '',
                        label: '',
                        name: ''
                    }

                    this.form_type = 'post';
                },
                //新增顶级permission
                createParentPermission: function () {
                    this.resetPermission();
                },
                //添加permission
                createPermission: function (parent_id) {
                    //设置上级菜单，并重置数据
                    this.resetPermission();
                    this.permission.parent_id = parent_id;
                },
                //编辑permission
                editPermission: function (id) {
                    this.form_type = 'put';

                    //ajax获取当前的permission
                    this.$http.get('/system/permission/' + id + '/edit').then((response) => {
                        this.permission = response.body
                    });
                },
                onSubmit: function () {
                    if (this.permission.name == undefined || this.permission.label == undefined) {
                        return false;
                    }

                    //判断是新增还是修改
                    if (this.form_type == 'post') {
                        this.storePermission();
                    } else {
                        this.updatePermission();
                    }
                },
                //保存permission
                storePermission: function () {
                    this.$http.post('/system/permission', this.permission).then((response) => {
                        var data = response.body;
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        this.permissions = data.permissions;

                        var parent_id = this.permission.parent_id;
                        this.resetPermission();
                        this.permission.parent_id = parent_id;
                    });
                },
                //更新permission
                updatePermission: function () {
                    this.$http.put('/system/permission/' + this.permission.id, this.permission).then((response) => {
                        var data = response.body;
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        this.permissions = data.permissions;
                        this.resetPermission();
                    });
                },
                //删除permission
                destroyPermission: function (id) {
                    this.$http.delete('/system/permission/' + id).then((response) => {
                        var data = response.body;
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        this.permissions = data.permissions;
                    });
                }
            }
        })
    </script>
@endsection