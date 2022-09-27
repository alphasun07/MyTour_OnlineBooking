@php
use App\Helpers\Helper;
@endphp
<div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th colspan="2">Ticket Detail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td class="w-25">Ticket ID</td>
            <td>{{ $ticket->id }}</td>
            </tr>
            <tr>
            <td>Category</td>
            <td>{{ $ticket->category->title }}</td>
            </tr>
            <tr>
            <td>Name</td>
            <td>{{ $ticket->name }}</td>
            </tr>
            <tr>
            <td>Email</td>
            <td>{{ $ticket->email }}</td>
            </tr>
            <tr>
            <td>Ticket Priority</td>
            <td>{{ $ticket->priority ? $ticket->priority->title : ''}}</td>
            </tr>
            <tr>
            <td>Created Date</td>
            <td>{{ Helper::customFormatDate($ticket->created_at) }}</td>
            </tr>
            <tr>
            <td>Modified Date</td>
            <td>{{ Helper::customFormatDate($ticket->updated_at) }}</td>
            </tr>
        </tbody>
    </table>
</div>