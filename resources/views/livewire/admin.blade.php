<div class="container">
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Appointments</h2>
             <!-- Notification dropdown -->
    @if ($counter != 0)
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button"
            data-bs-toggle="dropdown" aria-expanded="false"><strong>Inactive</strong>
            <i style="font-size: " class="bi bi-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger">{{ $counter }}</span>
            
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
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
        
        <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                <td>
                                    {{-- <button class="btn btn-sm btn-primary" wire:click="accept({{ $item->id }})" wire:loading.attr="disabled">
                                                                <span wire:loading.remove>Approve/Reject</span>
                                                                <div wire:loading>
                                                                    <i class="fa fa-spinner fa-spin"></i> Updating...
                                                                </div>
                                                            </button> --}}
            
                                    {{-- <button class="btn btn-sm btn-danger text-white" wire:click="deleteModalShow({{ $item->id }})">Delete</button> --}}
            
                                    <button class="btn btn-sm btn-primary rounded-circle"
                                        @if ($item->status === 'Active') disabled @endif
                                        wire:click="confirmModalShow({{ $item->id }})">✓</button>
                                    <button class="btn btn-sm btn-danger rounded-circle"
                                        @if ($item->status === 'Inactive') disabled @endif
                                        wire:click="confirmModalShow({{ $item->id }})">X</button>
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
                {{-- Delete Modal Confirmation --}}
            </p>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="deleteModalShow">
        <div style="width: 250px" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <h5 class="modal-title text-center" id="deleteModalShowLongTitle">Send confirmation Email?</h5>
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
