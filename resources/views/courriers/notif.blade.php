<!DOCTYPE html>
<html>
<head>
    <title>Envoyer le Courrier</title>
</head>
<body>
    <h1>Envoyer le Courrier</h1>
    
    <form method="POST" action="{{ route('courriers.sendEmail', $courrier->id) }}" accept-charset="UTF-8">
        @csrf

        <label for="send_to">Envoyer à:</label>
        <select name="send_to" id="send_to" required>
            <option value="service">Tous les utilisateurs du service</option>
            <option value="specific_user">Un utilisateur spécifique</option>
        </select>

        <div id="specific_user_div" style="display: none;">
            <label for="user_id">Choisissez un utilisateur:</label>
            <select name="user_id" id="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-info btn-sm">Envoyer le Courrier</button>
    </form>

    <script>
        document.getElementById('send_to').addEventListener('change', function() {
            var display = this.value === 'specific_user' ? 'block' : 'none';
            document.getElementById('specific_user_div').style.display = display;
        });
    </script>
</body>
</html>
