<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 px-6 lg:px-8 bg-white dark:bg-slate-900">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        {{-- <x-application-logo class="mx-auto h-12 w-auto"/> --}}
        <h2 class="mt-6 text-center text-3xl font-extrabold text-[#B50209] ">{{config('app.name')}}</h2>
        <p class="mt-2 text-center text-sm text-gray-600 max-w dark:text-white">
            Use email & password to sign in
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-900 py-8 px-6 shadow rounded-lg sm:px-10">
            <form class="mb-0 space-y-6" wire:submit.prevent="submit">

                @error('login-message') <span class="text-danger error text-red-700">{{ $message }}</span>@enderror

                <div>
                    <x-input icon="user" label="Email" placeholder="Email" autocomplete="off" wire:model.lazy="email"/>
                </div>

                <div>
                    <x-input icon="key" type="password" label="Password" placeholder="Password" autocomplete="off"
                             wire:model.lazy="password"/>
                </div>


                <div>

                    <x-button wire:offline.attr="disabled"
                              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                            text-sm font-medium !text-white bg-[#B50209] !hover:bg-red-400 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-[#B50209]"
                              wire:click="submit" red
                              id="submitBtn" spinner="submit" label="Sign in" />
                </div>

                <div class="text-center">
                    <a href="" class="text-sm text-gray-600 dark:text-white hover:underline">
                        Forgot Password?
                    </a>
                    <p class="text-sm text-gray-500 dark:text-white mt-4">Copyright © 2023 UPay Bank PLC</a>
                        All Rights Reserved.</p>
                </div>
            </form>
        </div>
    </div>
</div>


