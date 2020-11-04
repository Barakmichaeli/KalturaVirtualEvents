<template>
    <tr>
        <th scope="row">{{entry.id}}</th>
        <td><img height="120px" width="150px" :src="entry.thumbnail_url" alt="Thumbnail"></td>
        <td>{{entry.name}}</td>
        <td>{{entry.entry_id}}</td>
        <td>{{entry.duration}}</td>
        <td>{{entry.created}}</td>
        <td>
            <button type="button" class="btn btn-outline-secondary play-button">
                <a :href="entry.watch_url" target="_blank">
                    <i class="fa fa-play"></i>
                    Play Media
                </a>
            </button>
        </td>
    </tr>
</template>

<script>
    export default {
        'name': 'Entry',
        props: ['entry']
    }
</script>
<style>
    .play-button:hover {
        background: white;
    }
    .play-button a:hover {
        text-decoration: none;
    }

    td {
        vertical-align: inherit !important;
    }
</style>
