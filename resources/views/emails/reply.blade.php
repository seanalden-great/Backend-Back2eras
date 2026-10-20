<div style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <h2 style="color: #ff1493;">BACK2ERAS Response</h2>
    <p>{{ $replyMessage }}</p>

    <br>
    <hr style="border: none; border-top: 1px solid #ccc;">
    <br>

    <p style="font-size: 12px; color: #666;">
        <strong>Your original message:</strong><br>
        Topic: {{ strtoupper($this->topic) }}<br>
        "{{ $originalMessage }}"
    </p>
</div>
