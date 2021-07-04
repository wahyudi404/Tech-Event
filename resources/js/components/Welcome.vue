<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-4" v-for="event in events">
                <div class="card border-none shadow" style="font-size: small;">
                    <img class="card-img-top" height="200px" style="object-fit: cover;" :src="'../images/' + event.image_url" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{ event.name_event }}</h5>
                        <p class="card-text">
                            <span><i class="fa fa-address-book mr-2" aria-hidden="true"></i> {{ event.address }}</span><br>
                            <span><i class="fa fa-clock mr-2" aria-hidden="true"></i> {{ event.date }}</span>
                        </p>
                        <p class="card-text">
                            {{ event.description.substring(0,100)+"..." }}
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <button @click.prevent="more(event.id)" class="btn btn-info text-light">LIHAT DETAIL</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            events: [],
            auth: window.authUser
        }
    },
    mounted(){
        this.getEvents()
    },
    methods: {
        getEvents(){
            axios.get('/api/home').then((response)=>{
                this.events = response.data
            });
        },
        more(id){
            this.$router.push({
                name: 'detail',
                params: {id}
            })
        }
    }
}
</script>
