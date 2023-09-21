<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <h3>Appointments</h3>
                            </div>
                            <div class="col-4">
                                <input class="form-control" type="search" wire:model="term" placeholder="Search"
                                    id="example-search-input">
                            </div>
                            <div class="col-2">
                                <!-- Notification dropdown -->
                                @if ($counter != 0)
                                    <div class="nav-item dropdown">
                                        <span>Inactive</span>
                                        <a class="nav-link dropdown-toggle hidden-arrow" href="#"
                                            id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i style="font-size: " class="bi bi-bell"></i>
                                            <span
                                                class="badge rounded-pill badge-notification bg-danger">{{ $counter }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="navbarDropdownMenuLink">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        {{-- <th>Apply at</th> --}}
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($inactiveCollection as $item)
                                                        <tr>
                                                            <td>{{ $item->id }}</td>
                                                            {{-- <td>{{$item->created_at}}</td> --}}
                                                            <td>{{ $item->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- <div class="row">
                                                <div class="col-sm m-3">
                                                    {{ $inactiveCollection->links() }}
                                                </div>
                                            </div> --}}
                                        </ul>
                                    </div>
                                @endif
                                <!-- Notification dropdown -->
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <div>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th>Time Slot</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- @dd($user) --}}
                                    @foreach ($collection as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->timeSlot }}</td>
                                            <td>
                                                @if ($item->status === 'Inactive')
                                                    <a href="#" class="btn btn-sm btn-danger p-0">Inactive</a>
                                                @else
                                                    <a href="#" class="btn btn-sm btn-success p-0">Active</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <button class="btn btn-sm btn-primary" wire:click="accept({{ $item->id }})" wire:loading.attr="disabled">
                                                    <span wire:loading.remove>Approve/Reject</span>
                                                    <div wire:loading>
                                                        <i class="fa fa-spinner fa-spin"></i> Updating...
                                                    </div>
                                                </button> --}}

                                                {{-- <button class="btn btn-sm btn-danger text-white" wire:click="deleteModalShow({{ $item->id }})">Delete</button> --}}

                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="confirmModalShow({{ $item->id }})">Approve/Reject</button>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm ms-5 p-0">
                                    {!! $collection->links() !!}
                                </div>
                                <div class="col-sm-3">
                                    Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of
                                    {{ $pagination['total'] }} users
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal Confirmation --}}
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="deleteModalShow">
        <div style="width: 250px" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <h5 class="modal-title text-center" id="deleteModalShowLongTitle">Are you sure to change Status?</h5>
                </div>
                <div class="modal-body text-center">
                    <button type="button" wire:click="accept" class="btn btn-success"
                        wire:loading.attr="disabled">Yes</button>
                    <button type="button" class="btn btn-secondary" wire:click="deleteModalHide"
                        wire:loading.attr="disabled" wire:target="accept">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal Confirmation end --}}
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    window.addEventListener('deleteModalShow', event => {
        $("#deleteModalShow").modal("show");
    });
    window.addEventListener('deleteModalHide', event => {
        $("#deleteModalShow").modal("hide")
    });
    window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });
</script>
