<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">    
                        <p class="title">Liste des régions</p>            
                    </div>

                    <div class="card-body">
                        <div id="loadingIndicatorCtn">
	                        <div class="fa-3x loadingIndicator">
                                <i class="fas fa-sync fa-spin"></i>
                            </div>
	                    </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6 carte">
                                Carte
                            </div>
                            <div class="col-xl-6 col-md-6 liste">                                                                 
                                <ul>     
                                    <li v-bind:key="region.nom_region" v-for="region in orderBy(regions, 'nom_region')">
                                        <router-link class="" v-bind:to="`/region/${region.id}`">{{region.nom_region}}</router-link>
                                    </li> 
                                </ul>                       
                            </div> 
                        </div>            
                    </div>
                    <div class="card-footer">
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'Regions',
        data () {            	
            return {
                regions: {}                             
            }
        },        
        created () {
            axios.get('http://localhost:8000/api/regions')
            .then(response => {
                console.log(response)
                this.regions = response.data
                // this.comp = JSON.parse(response.data)
                console.log(this.regions.nom_region)
                document.getElementById("loadingIndicatorCtn").style.display = 'none';
            })            
            .catch(Err => {
                // console.log(err)
            })        
        }
    }
</script>
<style scoped>
    p{
        font-size: 18px;
    }    
    ul{
        list-style: none;
    }    
	#loadingIndicatorCtn {
	   text-align: center;   
	   padding-top:2em;
	}
</style>