@extends('layouts.admin')

@section('title', 'Account Management')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Accounts</h1>
                    <p class="text-gray-500 mt-1">Manage admin, cashier, and kitchen staff accounts</p>
                </div>
                <button onclick="openAddModal()"
                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Account
                </button>
            </div>

            <!-- Accounts Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Role
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($accounts as $account)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $account->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $account->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800',
                                                'cashier' => 'bg-blue-100 text-blue-800',
                                                'kitchen' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $color = $roleColors[$account->role] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }} capitalize">
                                            {{ $account->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($account->is_active)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <button onclick="openEditModal({{ $account }})"
                                                class="text-blue-600 hover:text-blue-900 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                            @if ($account->id !== auth()->id())
                                                <button onclick="deleteAccount({{ $account->id }})"
                                                    class="text-red-600 hover:text-red-900 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            @else
                                                <div class="w-5"></div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Modal -->
    <div id="accountModal" class="hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Add Account</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="accountForm" onsubmit="submitForm(event)">
                <div class="p-6 space-y-4">
                    <input type="hidden" id="accountId">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                            <option value="cashier">Cashier</option>
                            <option value="kitchen">Kitchen</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                        <p id="passwordHint" class="text-xs text-gray-500 mt-1 hidden">Leave empty to keep current password
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const modal = document.getElementById('accountModal');
            const form = document.getElementById('accountForm');
            let isEdit = false;

            function openAddModal() {
                isEdit = false;
                document.getElementById('modalTitle').textContent = 'Add Account';
                document.getElementById('password').required = true;
                document.getElementById('passwordHint').classList.add('hidden');
                form.reset();
                document.getElementById('accountId').value = '';
                modal.classList.remove('hidden');
            }

            function openEditModal(account) {
                isEdit = true;
                document.getElementById('modalTitle').textContent = 'Edit Account';
                document.getElementById('password').required = false;
                document.getElementById('passwordHint').classList.remove('hidden');

                document.getElementById('accountId').value = account.id;
                document.getElementById('name').value = account.name;
                document.getElementById('email').value = account.email;
                document.getElementById('role').value = account.role;

                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            async function submitForm(e) {
                e.preventDefault();

                const id = document.getElementById('accountId').value;
                const url = isEdit ? `/dashboard/accounts/${id}` : '/dashboard/accounts';
                const method = isEdit ? 'PUT' : 'POST';

                const formData = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    role: document.getElementById('role').value,
                    password: document.getElementById('password').value
                };

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    });

                    if (!response.ok) {
                        const data = await response.json();
                        throw new Error(data.message || 'Something went wrong');
                    }

                    const result = await response.json();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: result.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message
                    });
                }
            }

            function deleteAccount(id) {
                Swal.fire({
                    title: 'Delete Account?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/dashboard/accounts/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                throw new Error(data.message);
                            }

                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message
                            });
                        }
                    }
                })
            }

            // Close modal on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        </script>
    @endpush
@endsection
