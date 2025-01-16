<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Publications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search Bar -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Search Comments:</h3>
                <form action="{{ route('posts.index') }}" method="GET">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="search" placeholder="Search..." 
                               class="border rounded-lg py-2 px-4 w-1/2 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                               value="{{ request()->get('search') }}">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Search
                        </button>
                    </div>
                </form>
                <?php 
                $search = ($_GET['search'] ?? ''); 
                // Pour eviter l'attaque par reflexion sur la recherche on peut nettoyer les entrées par :
                //$search = strip_tags($_GET['search'] ?? ''); // Remove tags
                //$search = htmlspecialchars(($_GET['search'] ?? ''), ENT_QUOTES, 'UTF-8'); // Encoder en charactètre HTML
                
                echo "<pre style='color: white;'>Results for: $search</pre>";
                ?>
            </div>
            <!-- Add Advertisement Form -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Ajouter une publication</h3>
                <form action="{{ route('ads.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <textarea name="title" rows="3" class="form-control border rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Titre"></textarea>
                        <textarea name="content" rows="3" class="form-control border rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contenu de la publicité"></textarea>
                        <button type="submit" class="mt-2 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Ajouter la publication
                        </button>
                    </div>
                </form>
            </div>
            <!-- Publications List -->
            <div class="space-y-6">
                @foreach ($posts as $post)
                    <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-3xl mx-auto">
                            <div class="card mb-6">
                                <div class="card-body">
                                    <h3 class="font-bold text-xl text-gray-900 dark:text-white">{{ $post->title }}</h3>
                                    <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $post->content }}</p>

                                    <div class="mt-4">
                                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Commentaires:</h4>
                                        <div class="space-y-4 mt-2">
                                            @foreach ($post->comments as $comment)
                                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                                   <p class="text-gray-700 dark:text-gray-300">{!! $comment->content !!}</p>  <!--  XSS vulnerability -->
                                                  <!--<p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>    Solution -->
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Comment Form -->
                                    <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mt-6">
                                        @csrf
                                        <textarea name="content" rows="3" class="form-control border rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Votre commentaire"></textarea>
                                        <button type="submit" class="mt-2 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            Commenter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
