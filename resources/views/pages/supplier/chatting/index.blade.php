@extends('layouts.app')
@section('content')
    <div class="content-heading">MailBox</div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="d-flex mb-2">
                <a class="btn btn-purple btn-sm mb-compose-button" href="#">
                    <em class="fas fa-pencil-alt"></em>
                    <span>Compose</span>
                </a>
                <button class="btn btn-sm btn-secondary mb-toggle-button ml-auto" type="button" data-toggle="collapse" data-target=".mb-boxes"><em class="fa fa-bars fa-fw fa-lg"></em></button>
            </div>
            <!-- START mailbox list-->
            <div class="mb-boxes collapse show">
                <div class="card card-default">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item p-2"><small class="text-muted">MAILBOXES</small></li>
                            <li class="nav-item active">
                                <a class="nav-link d-flex align-items-center" href="#">
                                    <em class="fa-fw fa-lg fa fa-inbox mr-2"></em>
                                    <span>Inbox</span>
                                    <span class="ml-auto badge badge-green">42</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#">
                                    <em class="fa-fw fa-lg fa fa-star mr-2"></em>
                                    <span>Starred</span>
                                    <span class="ml-auto badge badge-green">10</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#">
                                    <em class="fa-fw fa-lg far fa-paper-plane mr-2"></em>
                                    <span>Sent</span>
                                    <span class="ml-auto badge badge-green">0</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#">
                                    <em class="fa-fw fa-lg fa fa-edit mr-2"></em>
                                    <span>Draft</span>
                                    <span class="ml-auto badge badge-green">5</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-flex align-items-center" href="#">
                                    <em class="fa-fw fa-lg fas fa-trash-alt mr-2"></em>
                                    <span>Trash</span>
                                    <span class="ml-auto badge badge-green">0</span>
                                </a>
                            </li>
                            <li class="p-2 nav-item"><small class="text-muted">LABELS</small></li>
                            <li class="nav-item">
                                <a class="py-1 nav-link" href="#">
                                    <span class="circle bg-danger"></span>
                                    <span>Red</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="py-1 nav-link" href="#">
                                    <span class="circle bg-pink"></span>
                                    <span>Pink</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="py-1 nav-link" href="#">
                                    <span class="circle bg-info"></span>
                                    <span>Blue</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="py-1 nav-link" href="#">
                                    <span class="circle bg-warning"></span>
                                    <span>Yellow</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END mailbox list-->
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <!-- START action buttons-->
            <div class="d-flex mb-2">
                <div class="btn-group">
                    <button class="btn btn-secondary btn-sm" type="button"><em class="fas fa-reply text-gray-dark"></em></button>
                    <button class="btn btn-secondary btn-sm" type="button"><em class="fas fa-reply-all text-gray-dark"></em></button>
                    <button class="btn btn-secondary btn-sm" type="button"><em class="fas fa-share text-gray-dark"></em></button>
                </div>
                <div class="btn-group ml-auto">
                    <button class="btn btn-secondary btn-sm" type="button"><em class="fa fa-exclamation text-gray-dark"></em></button>
                    <button class="btn btn-secondary btn-sm" type="button"><em class="fa fa-times text-gray-dark"></em></button>
                </div>
            </div>
            <!-- END action buttons-->
            <div class="card card-default">
                <div class="card-body">
                    <!-- p.lead.text-centerNo mails here-->
                    <table class="table table-hover mb-mails">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mb-mail-avatar mr-2" alt="Mail Avatar" src="/img/user/01.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Admin web application</div>
                                            <div class="mb-mail-from">Evelyn Holmes</div>
                                            <div class="mb-mail-preview">Fusce gravida, diam ac adipiscing pretium, sem nibh bibendum diam, non consequat quam metus non nunc</div>
                                        </div>
                                        <div class="mb-mail-date ml-auto">10 minutes ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/02.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Admin theme based on Bootstrap and AngularJS</div>
                                            <div class="mb-mail-from">Allison Grant</div>
                                            <div class="mb-mail-preview">Nunc eget lacinia felis. Pellentesque sollicitudin sollicitudin erat, in imperdiet tortor fringil</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">1 day ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/03.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Nested route mailbox application</div>
                                            <div class="mb-mail-from">Daryl Carlson</div>
                                            <div class="mb-mail-preview">Nulla facilisi. Sed sit amet sem vel purus pulvinar venenatis. Class aptent taciti</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">2 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/04.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Angular with lazy load components</div>
                                            <div class="mb-mail-from">George Clark</div>
                                            <div class="mb-mail-preview">Integer sit amet vulputate mauris. Proin purus nisl, tempor ut tempor at, ornare vel mauris. Ut ac l</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">3 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg fa fa-star text-warning"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/05.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Translation ready and RTL support!</div>
                                            <div class="mb-mail-from">Bonnie Bowman</div>
                                            <div class="mb-mail-preview">Integer sit amet vulputate mauris. Proin purus nisl, tempor ut tempor at, ornare vel mauris. Ut ac l</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">4 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/06.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Don&apos;t forget to check latest updates!</div>
                                            <div class="mb-mail-from">Warren Watts</div>
                                            <div class="mb-mail-preview">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In at conseq</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">5 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg fa fa-star text-warning"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/07.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">We have to meet someday</div>
                                            <div class="mb-mail-from">Elijah Ward</div>
                                            <div class="mb-mail-preview">Nunc hendrerit, neque ullamcorper eleifend ornare, arcu est bibendum ipsum, id malesuada sem justo v</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">6 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg fa fa-star text-warning"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/08.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">New issue found</div>
                                            <div class="mb-mail-from">Colleen Payne</div>
                                            <div class="mb-mail-preview">Integer sit amet vulputate mauris. Proin purus nisl, tempor ut tempor at, ornare vel mauris. Ut ac l</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">7 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg far fa-star text-muted"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/09.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Issue #5478 awaiting reply</div>
                                            <div class="mb-mail-from">Rose Fox</div>
                                            <div class="mb-mail-preview">Sed eu felis nulla. Nunc malesuada sapien at risus eleifend ut lacinia sem pretium.</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">8 days ago</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox c-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center"><em class="fa-lg fa fa-star text-warning"></em></td>
                                <td>
                                    <div class="d-flex">
                                        <img class="mr-2 mb-mail-avatar" alt="Mail Avatar" src="/img/user/10.jpg" />
                                        <div class="mb-mail-meta">
                                            <div class="mb-mail-subject">Check Angle for your next startup project</div>
                                            <div class="mb-mail-from">Jenny Knight</div>
                                            <div class="mb-mail-preview">Morbi varius sem quis purus suscipit tempus. Integer fermentum accumsan metus, id sagittis ipsum mol</div>
                                        </div>
                                        <div class="ml-auto mb-mail-date">9 days ago</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<form id="action-form" action="" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input type="hidden" name="id">
</form>
@endsection
@section('scripts')
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="{{ mix('/js/datatable.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#datatable').DataTable();
    });

    function execRemove(method, hashid) {
        $("#action-form").attr('action', 'user/delete/' + hashid);
        $("#action-form input[name=_method]").val(method);
        $("#action-form").submit();
    }

    function willRemove(id, method) {
        swal({
            title: "Apakah Anda Yakin?",
            text: "anda yakin menghapus data ini?",
            icon: "warning",
            buttons: ["Batal", "Ya"]
        })
        .then(function(willDelete) {
            if (willDelete) {
                if (method === "DELETE") execRemove('PATCH', id)
                    else execRemove('DELETE', id)
                }
        });
    };

    function restore (hashid) {
        $("#action-form").attr('action', 'user/restore/' + hashid);
        $("#action-form input[name=_method]").val("POST");
        $("#action-form").submit();
    };

    $(document).on('click','#call_id', function() {
        $.get("{{ route('call') }}",{call_id:$(this).val()},function(res){
            console.log('response', res);
        },'json');
    });
</script>
@endsection