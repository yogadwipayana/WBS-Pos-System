@props(['title', 'subtitle' => null, 'actions' => null])

<div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h1>
                @if($subtitle)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            
            @if($actions)
                <div class="flex items-center space-x-3">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>
