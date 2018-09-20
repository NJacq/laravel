<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center" v-show="isLoading">
                    <div class="card-body p-5">
                        <i class="fas fa-3x fa-sync fa-spin"></i>
                    </div>
                </div>
                <div class="card card-default" v-show="!isLoading">
                   <div class="card-header">
                        <div class="row">
                            <router-link v-bind:to="`/regions`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">                              
                                <small class="text-muted">Région</small><br>
                                {{region.nom_region}}
                            </h5>
                        </div>
                    </div>      
                    <div class="card-body">              
                        <p class="text-justify" v-if="region.etablissements > 1">En région {{region.nom_region}}, il y a <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                        <p class="text-justify" v-else-if="region.etablissements > 0">En région {{region.nom_region}}, il y a <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissement</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                        <p class="text-justify" v-else>En région {{region.nom_region}}, il y a <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong> aucun établissement</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>

                        <table class="table table-striped table-sm table-bordered" v-if="region.ftthregions>[]">                                                                         
                            <thead class="table-secondary">                                      
                                <tr>
                                    <th>Période</th>
                                    <th>                                                                                                                   
                                        Pourcentage de locaux raccordables (sur {{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                                    </th>                
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthregion.id" v-for="ftthregion in orderBy(region.ftthregions, 'annee', 'trimestre', -1)">   
                                    <td>                                 
                                        {{ftthregion.trimestre}}<sup>{{ftthregion.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthregion.annee}}                                      
                                    </td>                                       
                                    <td>     
                                        {{ftthregion.pourcentage}}
                                        <small class="text-muted">({{ftthregion.nombre_locaux | currency('', 0, { thousandsSeparator: ' ' })}} locaux)</small>
                                    </td>
                                </tr>          
                            </tbody>
                        </table>              
       
                        <div col-md-12 col-xl-12 v-if="region.ftthregions>[]">
                            Pourcentage de locaux raccordables par nombre d'opérateurs   
                            <table class="table table-striped table-sm table-bordered">
                                <thead class="table-secondary">       
                                    <tr>
                                        <th>Période</th>                                                                                       
                                        <th>Au moins un opérateur</th>
                                        <th>Au moins deux opérateurs</th>
                                        <th>Au moins trois opérateurs</th>
                                        <th>Au moins quatre opérateurs</th>                                        
                                    </tr>                  
                                </thead>
                                <tbody> 
                                    <tr v-bind:key="ftthregion.id" v-for="ftthregion in orderBy(region.ftthregions, 'annee', 'trimestre', -1)">                       
                                        <td>                                                                                                                                 
                                            {{ftthregion.trimestre}}<sup>{{ftthregion.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthregion.annee}}
                                        </td>
                                        <td>                                                                                                          
                                            {{ftthregion.unoperateur}} 
                                        </td>  
                                        <td>                                                                                                                                 
                                          {{ftthregion.deuxoperateurs}} 
                                        </td>  
                                        <td>                                                                                                                                  
                                            {{ftthregion.troisoperateurs}}                             
                                        </td>  
                                        <td>                                                                                                                              
                                            {{ftthregion.quatreoperateurs}} 
                                        </td>             
                                    </tr>
                                </tbody>                               
                            </table>                                
                        </div>
                        <div class="col-md-12 col-xl-12" v-else>
                            <p>Données indisponibles</p>                                
                        </div>                      
                                                     
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <l-map style="height: 400px" :zoom="zoom" :center="center">
                                    <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                                    <l-geo-json v-if="show" :geojson="geojson" :options="options"></l-geo-json>
                                </l-map>
                            </div>
                            <div class="col-xl-6 col-md-6">                      
                                <v-select label="nom_departement" items="" @input='onSelectDepartements' :options="region.departements" placeholder="Départements">
                                    <span slot="no-options">Aucun résultat</span>
                                </v-select>                                
                            </div>
                        </div>

                        <div v-show="statdepartements.length>0">
                            <p v-if="statdepartements.length>1">Départements ayant la plus forte progression sur les 3 derniers trimestres</p>
                            <p v-else>Département ayant la plus forte progression sur les 3 derniers trimestres</p>
                            
                            <ul>      
                                <li v-bind:key="statdepartement.id" v-for="statdepartement in statdepartements" v-if="statdepartement.pourcentage_progression>0">
                                <strong>{{statdepartement.departement.nom_departement}}</strong> avec une progression de <strong>{{statdepartement.pourcentage_progression}}%</strong> des locaux raccordables.
                               </li> 
                            </ul> 
                        </div>
                        <div v-show="ftthtopdepartements.length>0">
                            <p v-if="ftthtopdepartements.length>1">Départements ayant le plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                            <p v-else>Département ayant le plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                            <ul>     
                                <li v-bind:key="ftthtopdepartement.id" v-for="ftthtopdepartement in ftthtopdepartements">                               
                                    <strong>{{ftthtopdepartement.departement.nom_departement}}</strong> avec {{ftthtopdepartement.pourcentage}} de locaux raccordables
                                </li> 
                            </ul> 
                        </div>  

                    </div>
                    <div class="card-footer">               
                        <router-link class="col-xl-6" v-bind:to="`/regions`"><button type="button" class="btn btn-primary">Retour à la liste des régions</button></router-link>  
                        <router-link class="col-xl-6" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link>
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
        methods:{
            onSelectDepartements(departements) {               
                this.$router.push({ path: '/departement/' + departements.id })
            },
            // highlightFeature(e) {
            //     var layer = e.target;

            //     this.layer.setStyle({
            //         weight: 5,
            //         color: '#666',
            //         dashArray: '',
            //         fillOpacity: 0.7
            //     });

            //     if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            //         this.layer.bringToFront();
            //     }
            // },
            // resetHighlight(e) {
            //     this.geojson.resetStyle(e.target);
            // }       
        },
        name: 'Region',
        components: {
            LMap,
            LTileLayer,
            LGeoJson,
            LMarker
        },
        data () {            
            return {                                 
                region: [], 
                statdepartements: [],
                ftthtopdepartements: [],
                li:{},                              
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
            this.isLoading = true       
            this.id = this.$route.params.id  
                  
            axios.get('api/regions/'+ this.id)   
            .then(response => {
                this.region = response.data
                // console.log(this.region)                      
          
            }),

            axios.get('api/stattopdepartements/region/' + this.id)   
            .then(response => {
                this.statdepartements = response.data
                // console.log(this.statdepartements)                      
          
            }),

            axios.get('api/ftthtopdepartements/region/' + this.id)
               .then(response => {
                this.ftthtopdepartements = response.data
                console.log(this.ftthtopdepartements)                      
          
            }),

            axios.get('api/departements/geojson')
            .then(response => {                
                this.geojson = response.data;
                // this.geojsonreg = response.data.features[12].properties;
                // console.log(this.geojsonreg) 
                this.isLoading = false     
            })
        }
    }
    
</script>
<style scoped>
    
</style>
