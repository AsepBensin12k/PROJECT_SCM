<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengadaan Bahan Baku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <i class="fas fa-clipboard-list text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Pengadaan Bahan Baku</span>
                        <span class="text-amber-100 text-xs font-medium">ROJEMBER</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl border border-white/30">
                        <div class="bg-white/30 p-1.5 rounded-full">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-sm font-semibold leading-none">
                                Welcome, {{ Auth::user()->name }}
                            </span>
                            <span class="text-amber-100 text-xs">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64 overflow-x-hidden overflow-y-auto transition-all duration-500">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-amber-700">📦 Manajemen Pengadaan Bahan Baku</h1>
                <a href="{{ route('koordinator.procurements.create') }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    + Tambah Pengadaan
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg animate-fade-in">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div
                class="overflow-x-auto bg-white rounded-xl shadow-md transform transition-all duration-300 hover:shadow-lg">
                <table class="min-w-full">
                    <thead class="bg-amber-100 text-amber-800">
                        <tr>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">#
                            </th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Bahan Baku</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Supplier</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Tanggal Datang</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Qty</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Total Harga</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-left">
                                Status</th>
                            <th class="py-3 px-4 text-xs font-medium uppercase tracking-wider text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($procurements as $key => $proc)
                            <tr class="border-t hover:bg-amber-50 transition-all duration-200">
                                <td class="py-3 text-sm font-medium px-4">{{ $key + 1 }}</td>
                                <td class="py-3 text-sm px-4">{{ $proc->material->name ?? '-' }}</td>
                                <td class="py-3 text-sm px-4">{{ $proc->supplier->name ?? '-' }}</td>
                                <td class="py-3 text-sm px-4">
                                    {{ \Carbon\Carbon::parse($proc->tanggal_datang)->format('d M Y') }}
                                </td>
                                <td class="py-3 text-sm  px-4">{{ $proc->qty }}</td>
                                <td class="py-3 text-sm  px-4">
                                    Rp{{ number_format($proc->total_harga, 0, ',', '.') }}</td>
                                <td class="py-3 text-sm font-medium px-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
                                        @if ($proc->status === 'sampai') bg-green-100 text-green-700
                                        @elseif($proc->status === 'dikirim')
                                            bg-yellow-100 text-yellow-700
                                        @elseif($proc->status === 'dibatalkan')
                                            bg-gray-200 text-gray-600 line-through
                                        @else
                                            bg-blue-100 text-blue-700 @endif">
                                        {{ ucfirst($proc->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if (in_array($proc->status, ['diproses', 'dikirim']))
                                        <a href="{{ route('koordinator.procurements.edit', $proc->id) }}"
                                            class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition-all hover:scale-105">
                                            Ubah Status
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-gray-500">Belum ada data pengadaan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Chart -->
            @php
                $procurementData = $procurements->map(function ($p) {
                    return [
                        'material' => $p->material->name ?? 'Unknown',
                        'tanggal' => \Carbon\Carbon::parse($p->tanggal_datang)->format('d M Y'),
                        'qty' => $p->qty,
                    ];
                });
            @endphp

            <div class="mt-10 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">📈 Statistik Pengadaan</h3>
                <div class="relative w-full h-[400px]">
                    <canvas id="procurementChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('procurementChart');
        const procurements = @json($procurementData);

        const uniqueDates = [...new Set(procurements.map(p => p.tanggal))];
        const uniqueMaterials = [...new Set(procurements.map(p => p.material))];

        const colors = [
            'rgba(251, 191, 36, 0.8)',
            'rgba(249, 115, 22, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(234, 88, 12, 0.8)',
            'rgba(217, 119, 6, 0.8)',
            'rgba(202, 138, 4, 0.8)',
            'rgba(180, 83, 9, 0.8)',
        ];

        const datasets = uniqueMaterials.map((mat, i) => {
            const data = uniqueDates.map(date => {
                const item = procurements.find(p => p.tanggal === date && p.material === mat);
                return item ? item.qty : 0;
            });
            return {
                label: mat,
                data,
                backgroundColor: colors[i % colors.length],
                borderRadius: 8
            };
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: uniqueDates,
                datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#92400e',
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            padding: 16
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#78350f',
                        bodyColor: '#92400e',
                        borderColor: '#fbbf24',
                        borderWidth: 1,
                        callbacks: {
                            title: ctx => ctx[0].label,
                            label: ctx => ctx.dataset.label + ': ' + ctx.formattedValue + ' unit'
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal Pengadaan',
                            color: '#92400e',
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: '#92400e',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Barang Masuk',
                            color: '#92400e',
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: '#92400e'
                        },
                        grid: {
                            color: 'rgba(217, 119, 6, 0.1)'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });

        window.addEventListener('resize', () => chart.resize());
    </script>
</body>

</html>
