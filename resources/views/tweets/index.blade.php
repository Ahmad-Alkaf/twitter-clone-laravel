<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tweets.store') }}">
            @csrf
            <textarea name="message" placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Tweet') }}</x-primary-button>
        </form>


        <div class="w-100 mx-auto mt-10">
            <div class="relative">
                <ul class="relative md:mx-32 mx-md-0 flex list-none  rounded-xl bg-blue-gray-50/60 p-1" data-tabs="tabs"
                    role="list">
                    <li class="z-30 flex-auto text-center">
                        <a class="text-slate-700 z-30 mb-0 flex w-full cursor-pointer items-center justify-center rounded-lg border-0 bg-inherit px-0 py-1 transition-all ease-in-out"
                            data-tab-target="" active="" role="tab" aria-selected="true"
                            aria-controls="for-you">
                            <span class="ml-1">{{ __('For You') }}</span>
                        </a>
                    </li>
                    <li class="z-30 flex-auto text-center">
                        <a class="text-slate-700 z-30 mb-0 flex w-full cursor-pointer items-center justify-center rounded-lg border-0 bg-inherit px-0 py-1 transition-all ease-in-out"
                            data-tab-target="" role="tab" aria-selected="false" aria-controls="my-tweets">
                            <span class="ml-1">{{ __('My Tweets') }}</span>
                        </a>
                    </li>
                </ul>
                <hr class="my-3">
                <div data-tab-content="" class="p-5">
                    <div class="block opacity-100 transition-opacity" id="for-you" role="tabpanel">
                        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                            @foreach ($forYouTweets as $tweet)
                                <div class="p-6 flex space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-gray-800">{{ $tweet->user->name }}</span>
                                                <small
                                                    class="ml-2 text-sm text-gray-600">{{ $tweet->created_at->format('j M Y, g:i a') }}</small>
                                                @unless ($tweet->created_at->eq($tweet->updated_at))
                                                    <small class="text-sm text-gray-600">&middot;
                                                        {{ __('edited') }}</small>
                                                @endunless
                                            </div>
                                            @if ($tweet->user->is(auth()->user()))
                                                <x-dropdown>
                                                    <x-slot name="trigger">
                                                        <button>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                    </x-slot>
                                                    <x-slot name="content">
                                                        <x-dropdown-link :href="route('tweets.edit', $tweet)">
                                                            {{ __('Edit') }}
                                                        </x-dropdown-link>
                                                        <form method="POST"
                                                            action="{{ route('tweets.destroy', $tweet) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <x-dropdown-link :href="route('tweets.destroy', $tweet)"
                                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                                {{ __('Delete') }}
                                                            </x-dropdown-link>
                                                        </form>
                                                    </x-slot>
                                                </x-dropdown>
                                            @endif
                                        </div>
                                        <p class="mt-4 text-lg text-gray-900">{{ $tweet->message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="hidden opacity-0 transition" id="my-tweets" role="tabpanel">
                        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                            @foreach ($myTweets as $tweet)
                                <div class="p-6 flex space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-gray-800">{{ $tweet->user->name }}</span>
                                                <small
                                                    class="ml-2 text-sm text-gray-600">{{ $tweet->created_at->format('j M Y, g:i a') }}</small>
                                                @unless ($tweet->created_at->eq($tweet->updated_at))
                                                    <small class="text-sm text-gray-600">&middot;
                                                        {{ __('edited') }}</small>
                                                @endunless
                                            </div>
                                            @if ($tweet->user->is(auth()->user()))
                                                <x-dropdown>
                                                    <x-slot name="trigger">
                                                        <button>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                    </x-slot>
                                                    <x-slot name="content">
                                                        <x-dropdown-link :href="route('tweets.edit', $tweet)">
                                                            {{ __('Edit') }}
                                                        </x-dropdown-link>
                                                        <form method="POST"
                                                            action="{{ route('tweets.destroy', $tweet) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <x-dropdown-link :href="route('tweets.destroy', $tweet)"
                                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                                {{ __('Delete') }}
                                                            </x-dropdown-link>
                                                        </form>
                                                    </x-slot>
                                                </x-dropdown>
                                            @endif
                                        </div>
                                        <p class="mt-4 text-lg text-gray-900">{{ $tweet->message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
<script src="https://unpkg.com/@material-tailwind/html@latest/scripts/tabs.js"></script>
