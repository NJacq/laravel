<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">                    
                        <img class="logo" src="http://localhost/laravel/resources/assets/media/netalis_logo.jpg">                 
                    </div>
                    <div class="card-body">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            
                        <router-link v-bind:to='"/regions"'><button>Accèder aux données</button></router-link>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    
</script>
<style scoped>
    .card-header[data-v-41daeb37] {
        background-color: "#157bf9";
    }
    .logo{
        width: 20%;
    }
    p{
        font-size: 18px;
    }
</style>