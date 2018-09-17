<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">    
                        <h5><strong>Liste des régions</strong></h5>            
                    </div>

                    <div class="card-body">
                        <div id="loadingIndicatorCtn">
	                        <div class="fa-3x loadingIndicator">
                                <i class="fas fa-sync fa-spin"></i>
                            </div>
	                    </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6 carte">
                                <l-map style="height: 400px" :zoom="zoom" :center="center">
                                    <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                                    <l-geo-json v-if="show" :geojson="geojson" :options="options"></l-geo-json>
                                    <!-- <l-marker :lat-lng="marker"></l-marker> -->
                                </l-map>
                            </div>
                            <div class="col-xl-6 col-md-6 liste">                                                                 
                                <ul>     
                                    <li v-bind:key="region.id" v-for="region in orderBy(regions, 'nom_region')">
                                        <router-link class="" v-bind:to="`/region/${region.id}`">{{region.nom_region}}</router-link>
                                    </li> 
                                </ul>                   
                            </div> 
                        </div>


                        <div>
                            <p>Régions ayant la plus forte progression sur les 3 derniers trimestres</p>
                            <ul>     
                                <li v-bind:key="statregion.id" v-for="statregion in statregions">
                               
                                    <strong>{{statregion.region.nom_region}}</strong> avec une progression de {{statregion.pourcentage_progression}}% des locaux raccordables. 
                                </li> 
                            </ul> 



                            <p>Régions ayant le plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                            <ul>     
                                <li v-bind:key="ftthtopregion.id" v-for="ftthtopregion in ftthtopregions">
                               
                                    <strong>{{ftthtopregion.region.nom_region}}</strong> avec {{ftthtopregion.pourcentage}} de locaux raccordables
                                </li> 
                            </ul> 

                        </div>            
                    </div>
                    <div class="card-footer text-center">
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>

    import { LMap, LTileLayer,  LGeoJson, LMarker } from 'vue2-leaflet';
    import axios from 'axios'
    export default {
        name: 'Regions',
        components: {
            LMap,
            LTileLayer,
            LGeoJson,
            LMarker
        },
        data () {            	
            return {
                regions: [], 
                ftthtopregions: [],
                statregions: [],                                        
                show: true,
                zoom:5,
                center:[46.413220, 1.419482],
                geojson: null,
                options: {
                    style: function () {
                    return {                              
                        weight: 1,
                        color: '#003150',
                        opacity: 1,
                        fillColor: '#007bff',
                        fillOpacity: 1                   
                    }
                }
            },

            url:'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_nolabels/{z}/{x}/{y}{r}.png', 
            attribution:'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            marker: L.latLng(47.413220, 0.219482),
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 20,
            ext: 'png'
            }
        },
        created () {
            axios.get('http://localhost:8000/api/regions')
            .then(response => {
      
                this.regions = response.data    
                // this.comp = JSON.parse(response.data)
                
                document.getElementById("loadingIndicatorCtn").style.display = 'none';
            })            
            .catch(Err => {
                // console.log(err)
            }),
            axios.get("http://localhost:8000/api/regions/geojson").then(response => {
                this.geojson = response.data;
            }),
            axios.get('/api/ftthregions?trimestre=1&annee=2018')
            .then(response => {      
                this.ftthtopregions = response.data 
                console.log(this.ftthtopregions)
            });  

            axios.get("/api/stattopregion/{id}")
            .then(response => {
                this.statregions = response.data
                console.log(this.statregions)
            });
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