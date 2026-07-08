@extends('layouts.admin')
@section('title', 'Manage Hospitals - Admin Panel')
@section('page-title', 'Manage Hospitals')
@section('page-subtitle', 'Verify and manage hospital registrations')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Manage Hospitals</h1>
            <p class="text-gray-500 text-sm mt-1">Verify and manage hospital registrations across the platform</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                {{ $hospitals->where('status', 'approved')->count() }} Verified
            </span>
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                {{ $hospitals->where('status', 'pending')->count() }} Pending
            </span>
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                {{ $hospitals->where('status', 'rejected')->count() }} Rejected
            </span>
        </div>
    </div>

    @php
        $allHospitals = $hospitals;
        $searchQuery = request('query');
        $filterStatus = request('status');
        if ($searchQuery) {
            $allHospitals = $allHospitals->filter(function($h) use ($searchQuery) {
                return stripos($h->hospital_name, $searchQuery) !== false ||
                       stripos($h->email, $searchQuery) !== false ||
                       stripos($h->location ?? '', $searchQuery) !== false;
            });
        }
        if ($filterStatus) {
            $allHospitals = $allHospitals->where('status', $filterStatus);
        }
    @endphp

    <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.hospitals') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Search hospitals by name, email, or location..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition">
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-amber-500 text-white text-sm font-medium rounded-xl hover:bg-amber-600 transition shadow-sm">
                    Search
                </button>
                <a href="{{ route('admin.hospitals') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition inline-flex items-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-4 font-semibold">Hospital</th>
                        <th class="text-left px-6 py-4 font-semibold">Email</th>
                        <th class="text-left px-6 py-4 font-semibold">Location</th>
                        <th class="text-left px-6 py-4 font-semibold">Patients</th>
                        <th class="text-left px-6 py-4 font-semibold">Status</th>
                        <th class="text-left px-6 py-4 font-semibold">Joined</th>
                        <th class="text-left px-6 py-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($allHospitals as $h)
                    <tr class="hover:bg-amber-50/30 transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br 
                                    @if($h->status === 'approved') from-emerald-100 to-teal-100 text-emerald-700
                                    @elseif($h->status === 'rejected') from-red-100 to-rose-100 text-red-700
                                    @else from-amber-100 to-orange-100 text-amber-700 @endif 
                                    flex items-center justify-center text-sm font-bold shrink-0">
                                    {{ strtoupper(substr($h->hospital_name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $h->hospital_name }}</p>
                                    <p class="text-xs text-gray-400">ID: #{{ str_pad($h->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-0.5">
                                <p class="text-gray-600 text-sm">{{ $h->email }}</p>
                                <p class="text-xs text-gray-400">{{ $h->phone ?? 'No phone' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-600">{{ $h->location ?? 'Not specified' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $h->patients_count ?? 0 }}</span>
                            <span class="text-xs text-gray-400"> patients</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Verified'],
                                    'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Pending'],
                                    'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500', 'label' => 'Rejected'],
                                ];
                                $config = $statusConfig[$h->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} {{ $h->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400">
                            {{ $h->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                @if($h->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.hospital.approve', $h->id) }}" class="inline">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 hover:shadow-md transition shadow-sm flex items-center gap-1" title="Approve">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                @if($h->status !== 'rejected')
                                    <form method="POST" action="{{ route('admin.hospital.reject', $h->id) }}" class="inline">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 hover:shadow-md transition shadow-sm flex items-center gap-1" title="Reject">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    </form>
                                @endif
                                <button class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition view-details" title="View Details" data-name="{{ $h->hospital_name }}" data-email="{{ $h->email }}" data-location="{{ $h->location ?? 'Not specified' }}" data-status="{{ $config['label'] }}" data-status-class="{{ $config['bg'] }} {{ $config['text'] }}" data-phone="{{ $h->phone ?? 'Not provided' }}" data-address="{{ $h->address ?? 'Not provided' }}" data-patients="{{ $h->patients_count ?? 0 }}" data-joined="{{ $h->created_at->format('M d, Y') }}" data-id="{{ $h->id }}" data-actual-status="{{ $h->status }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($allHospitals->isEmpty())
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p class="text-gray-500 font-medium">@if(request('query') || request('status')) No hospitals match your criteria @else No hospitals registered yet @endif</p>
                            <p class="text-sm text-gray-400 mt-1">@if(request('query') || request('status')) Try adjusting your search or filter @else Hospitals will appear here once they register @endif</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition bg-white px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>

{{-- View Hospital Modal --}}
<div id="hospitalModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" data-aos="zoom-in">
        <div class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-gray-100 px-6 py-4 flex items-center justify-between rounded-t-3xl">
            <h3 class="text-xl font-bold text-gray-900">Hospital Details</h3>
            <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-xl transition text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6" id="modalContent">
        </div>
    </div>
</div>

<style>
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
</style>

<script>
document.querySelectorAll('.view-details').forEach(btn => {
    btn.addEventListener('click', function() {
        const modal = document.getElementById('hospitalModal');
        const content = document.getElementById('modalContent');
        const name = this.dataset.name;
        const email = this.dataset.email;
        const location = this.dataset.location;
        const status = this.dataset.status;
        const statusClass = this.dataset.statusClass;
        const phone = this.dataset.phone;
        const address = this.dataset.address;
        const patients = this.dataset.patients;
        const joined = this.dataset.joined;
        const id = this.dataset.id;
        const actualStatus = this.dataset.actualStatus;
        
        const isPending = actualStatus === 'pending';
        const dotClass = actualStatus === 'approved' ? 'bg-emerald-500' : actualStatus === 'rejected' ? 'bg-red-500' : 'bg-amber-500 animate-pulse';

        content.innerHTML = `
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-2xl font-bold text-amber-700">
                    ${name.substring(0, 2).toUpperCase()}
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900">${name}</h4>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium ${statusClass}">
                        <span class="w-1.5 h-1.5 rounded-full ${dotClass}"></span>
                        ${status}
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${email}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Phone</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${phone}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Location</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${location}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Patients</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${patients} patients</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Address</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${address}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Joined</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${joined}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Status</p>
                    <p class="text-sm font-medium text-gray-800 mt-1">${status}</p>
                </div>
            </div>
            ${isPending ? `
            <div class="flex gap-3 pt-4 mt-4 border-t border-gray-100">
                <form method="POST" action="/admin/hospitals/${id}/approve" class="inline">
                    <input type="hidden" name="_token" value="${document.querySelector('input[name=_token]')?.value || ''}">
                    <button class="px-6 py-2.5 bg-emerald-500 text-white font-semibold rounded-xl hover:bg-emerald-600 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Approve Hospital
                    </button>
                </form>
                <form method="POST" action="/admin/hospitals/${id}/reject" class="inline">
                    <input type="hidden" name="_token" value="${document.querySelector('input[name=_token]')?.value || ''}">
                    <button class="px-6 py-2.5 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reject Hospital
                    </button>
                </form>
            </div>
            ` : ''}
        `;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
});

function closeModal() {
    const modal = document.getElementById('hospitalModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('hospitalModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endsection