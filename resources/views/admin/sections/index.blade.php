<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Sections') }}
        </h2>
    </x-slot>

    <div x-data="adminQuizManager" x-init="sectionManager.fetchTests()" class="max-w-6xl mx-auto p-6 space-y-8">

        <!-- ✅ Flash Message -->
        <div x-show="sectionManager.flashMessage" x-transition
            :class="{
                'bg-green-100 border-green-400 text-green-700': sectionManager.flashType === 'success',
                'bg-red-100 border-red-400 text-red-700': sectionManager.flashType === 'error'
            }"
            class="border px-4 py-3 rounded relative">
            <span class="font-bold" x-text="sectionManager.flashType === 'success' ? '✔️' : '⚠️'"></span>
            <span x-text="sectionManager.flashMessage" class="ml-2"></span>
            <button @click="sectionManager.flashMessage = null"
                class="absolute top-0 bottom-0 right-0 px-4 py-3 text-xl">&times;</button>
        </div>

        <!-- ✅ Flash Notification -->



        <!-- ✅ Toggle Add Form -->
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">🗂️ Sections</h2>
            <button @click="sectionManager.toggleForm()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                <span x-text="sectionManager.showForm ? '➖ Close Form' : '➕ Add New Section'"></span>
            </button>
        </div>

        <!-- ✅ Add New Section Form -->
        <div x-show="sectionManager.showForm" class="bg-white shadow border rounded-lg p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" x-model="sectionManager.newTest.title"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Section Title">

                <input type="number" x-model="sectionManager.newTest.duration" min="1"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Duration (minutes)">

                <input type="text" x-model="sectionManager.newTest.description"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Short Description">
            </div>

            <div class="text-right">
                <button @click="sectionManager.addTest()"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 transition">
                    Save Section
                </button>
            </div>
        </div>

        <!-- ✅ Sections List -->
        <div class="space-y-4">
            <template x-for="section in sectionManager.tests" :key="section.id">
                <div
                    class="bg-white border rounded-lg shadow-sm p-5 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex-1 space-y-1 w-full">
                        <template x-if="sectionManager.editingTest && sectionManager.editingTest.id === section.id">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <input type="text" x-model="sectionManager.editingTest.title"
                                    class="w-full border rounded px-3 py-2">
                                <input type="number" x-model="sectionManager.editingTest.duration"
                                    class="w-full border rounded px-3 py-2">
                                <input type="text" x-model="sectionManager.editingTest.description"
                                    class="w-full border rounded px-3 py-2">
                            </div>
                        </template>

                        <template x-if="!sectionManager.editingTest || sectionManager.editingTest.id !== section.id">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800" x-text="section.title"></h3>
                                <p class="text-sm text-gray-600" x-text="section.description"></p>
                                <p class="text-xs text-gray-500" x-text="'Duration: ' + section.duration + ' mins'"></p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4 md:mt-0 flex gap-2 flex-wrap">
                        <template x-if="sectionManager.editingTest && sectionManager.editingTest.id === section.id">
                            <div class="flex gap-2">
                                <button class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700"
                                    @click="sectionManager.updateTest()">Save</button>
                                <button class="bg-gray-200 text-gray-800 px-4 py-1 rounded hover:bg-gray-300"
                                    @click="sectionManager.editingTest = null">Cancel</button>
                            </div>
                        </template>

                        <template x-if="!sectionManager.editingTest || sectionManager.editingTest.id !== section.id">
                            <div class="flex gap-2">
                                <button 
    @click="sectionManager.copySectionId(section.id)"
    class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700"
>
    Copy ID
</button>

                            


                                <button @click="sectionManager.edit(section)"
                                    class="bg-yellow-400 text-white px-4 py-1 rounded hover:bg-yellow-500">Edit</button>
                                <button @click="sectionManager.confirmDelete(section)"
                                    class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">Delete</button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- ✅ Confirm Delete Dialog -->
        <div x-show="sectionManager.deletingTest"
            class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center" style="backdrop-filter: blur(2px);">
            <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete Section?</h2>
                <p class="text-gray-700">This action cannot be undone. Are you sure you want to delete this section?</p>

                <div class="flex justify-end gap-3">
                    <button @click="sectionManager.deletingTest = null"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button @click="sectionManager.deleteConfirmed()"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
