<template>
    <div>
        <span class="badge badge-pill badge-secondary">{{count}}</span>
        <a title="Add this question to favorite" >
            <i :class="classes"> 
            </i>
        </a>
     
    </div>
</template>

<script>
export default {
    props: ['question'],

    data(){
        return {
            isFavorited: this.question.is_favorite,
            count: this.question.fav_count
        }
    },

    computed: {
        classes(){
            return [
                'fa fa-lg', 'fa-heart', 'text-secondary', 'favourite',
                this.isFavorited ? 'favorited' : '' 
            ];
        }
    }
}
</script>