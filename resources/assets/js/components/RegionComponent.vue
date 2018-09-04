<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                   <div class="card-header">      
                        <p class="title">Stats arcep de la région {{region.nom_region}}</p>
                    </div>

                    <div class="card-body">
                          <div id="loadingIndicatorCtn">
	                        <div class="fa-3x loadingIndicator">
                                <i class="fas fa-sync fa-spin"></i>
                            </div>
	                    </div>
                        <div >
                            <table class="table table-striped table-sm table-bordered">                 
                                    <thead class="table-primary">             
                                    <tr>                                  
                                        <th>Logements</th>
                                        <th>Établissements</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <tr> 
                                        <td class="cellule">{{region.logements}}</td>
                                        <td class="cellule">{{region.etablissements}}</td>
                                    </tr>          
                                </tbody>
                            </table>
                        </div>
            
<!--                                   
                        <ul>
                            <li v-bind:key="ftthregion.nom_region" v-for="ftthregion in ftthregions">
                                <p>Au moins un opérateur au PM via la mutualisation passive : {{ftthregion.unoperateur}} au {{ftthregion.trimestre}} de {{ftthregion.annee}}</p>
                                <p>Au moins deux opérateurs au PM via la mutualisation passive : {{ftthregion.deuxoperateurs}} au {{ftthregion.trimestre}} de {{ftthregion.annee}}</p>
                            </li>
                        </ul> -->                

                        <p>Tableau des opérateurs au PM via la mutualisation passive</p>    

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-sm table-bordered">
                                    <thead class="table-primary">       
                                        <tr>
                                            <th></th>                                                                                       
                                            <th>Au moins un opérateur</th>
                                            <th>Au moins deux opérateurs</th>
                                            <th>Au moins trois opérateurs</th>
                                            <th>Au moins quatre opérateurs</th>
                                        </tr>                  
                                    </thead>

                                    <tbody> 
                                        <tr>                       
                                            <td class="cellule premier">
                                                <ul>
                                                    <li v-bind:key="ftthregion.code_region" v-for="ftthregion in ftthregions">                                                                                  
                                                        {{ftthregion.trimestre}} {{ftthregion.annee}}
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li v-bind:key="ftthregion.code_region" v-for="ftthregion in ftthregions">                                                                                  
                                                        {{ftthregion.unoperateur}} 
                                                    </li>
                                                </ul>
                                            </td>  
                                            <td>
                                                <ul>
                                                    <li v-bind:key="ftthregion.code_region" v-for="ftthregion in ftthregions">                                                                                  
                                                        {{ftthregion.deuxoperateurs}} 
                                                    </li>
                                                </ul>
                                            </td>  
                                            <td>
                                                <ul>
                                                    <li v-bind:key="ftthregion.code_region" v-for="ftthregion in ftthregions">                                                                                  
                                                        {{ftthregion.troisoperateurs}} 
                                                    </li>
                                                </ul>
                                            </td>  
                                            <td>
                                                <ul>
                                                    <li v-bind:key="ftthregion.code_region" v-for="ftthregion in ftthregions">                                                                                  
                                                        {{ftthregion.quatreoperateurs}} 
                                                    </li>
                                                </ul>
                                            </td>                 
                                                                        
                                                </tr>                               
                                            
                                    </tbody>
                                
                                </table>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6 carte">
                                Carte
                            </div>
                            <div class="col-xl-6 col-md-6 liste">        
                                <ul>     
                                    <li v-bind:key="departement.nom_departement" v-for="departement in orderBy(departements, 'nom_departement')">
                                        <router-link class="" v-bind:to="`/departement/${departement.id}`">{{departement.nom_departement}}</router-link>
                                        </li> 
                                </ul> 
                            </div>
                        </div>                                                   
                    </div>
                    <div class="card-footer">                        
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link>
                        <router-link class="" v-bind:to="`/regions`"><button type="button" class="btn btn-primary">Retour à la liste des régions</button></router-link>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
   
    import axios from 'axios'
    export default {        
        name: 'Region',
        data () {
            return {
                region: {},                       
                departements : {},
                ftthregions: {},               
            }       
        },
        created () {
            this.id = this.$route.params.id          
            axios.get('http://localhost:8000/api/regions/'+ this.id)
            .then(response => {
                // console.log(response)
                this.region = response.data           
                this.departements = response.data.departements
                this.ftthregions = response.data.ftthregions
                console.log(this.ftthregions)
                // this.comp = JSON.parse(response.data)
                document.getElementById("loadingIndicatorCtn").style.display = 'none';
            })
            .catch(Err => {
                // console.log(err)
            })            
        }
    }
</script>
<style scoped>
    
</style>
