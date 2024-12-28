@extends('layouts.app')

@section('content')
    <div class="flex flex-col space-y-1 border-2 border-black p-2">
        <form action="{{route('tweet.store')}}" method="POST">
            @csrf
            <div class="flex flex-col">
                <label for="category">Категория</label>
                <select id="category" name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex flex-col">
                Имя
                <input type="text" name="username" required>
            </label>
            <label class="flex flex-col">
                Сообщение
                <input type="text" name="content" required>
            </label>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <h2 class="my-5">Твиты</h2>

    <div class="flex flex-col space-y-2">
        @foreach($tweets as $tweet)
            <div class="flex flex-col space-y-1 border-2 p-2 border-black">
                <div>
                    Категория: {{ $tweet->category->title }}
                </div>
                <div>
                   Имя: {{ $tweet->username }}
                </div>
                <div>
                    Сообщение: {{ $tweet->content }}
                </div>
                <div>
                    Дата: {{ $tweet->created_at }}
                </div>
            </div>
        @endforeach
    </div>
@endsection

<script>
    document.getElementById('messageForm').onsubmit = async function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value;

        if (message) {
            await fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });
            messageInput.value = '';
        }
    };

    async function fetchMessages() {
        const response = await fetch('/get-messages');
        const messages = await response.json();

        const messagesContainer = document.getElementById('messages');
        messagesContainer.innerHTML = '';

        messages.forEach(msg => {
            const msgElement = document.createElement('div');
            msgElement.textContent = msg.content;
            messagesContainer.appendChild(msgElement);
        });

        // Запускаем новый запрос через 1 секунду
        setTimeout(fetchMessages, 1000);
    }

    // Инициализация первого запроса
    fetchMessages();
</script>
