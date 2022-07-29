<div class="align-top text-sm text-gray-400">{{ $record['label'] }}</div>

<small class="block text-xl"><a href="{{ $record['link'] }}" style="color: cadetblue">{{ $record['title'] }}</a></small>

<div class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($record['executeTo'])->format('Y-m-d H:i') }} для {{ $record['responsible'] }}</div>

<div class="text-md text-wrap">{{ $record['text'] }}</div>
