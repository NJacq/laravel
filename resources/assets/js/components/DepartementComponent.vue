<template> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">                        
                        <p class="title">Stats arcep du département : {{departement.nom_departement}}</p>
                    </div>

                    <div class="card-body">
                        <div id="loadingIndicatorCtn">
	                        <div class="fa-3x loadingIndicator">
                                <i class="fas fa-sync fa-spin"></i>
                            </div>
	                    </div>                    

                        <table class="table table-striped table-sm table-bordered">                 
                            <thead class="table-primary">          
                                <tr>                                              
                                    <th class="cellule">Logements</th>
                                    <th class="cellule">Établissements</th>                                          
                                   
                                </tr>
                            </thead>
                            <tbody>   
                                <tr> 
                                    <td class="cellule">{{departement.logements}}</td>
                                    <td class="cellule">{{departement.etablissements}}</td>                                                                                       
                                </tr>          
                            </tbody>
                        </table>                   
                        <table class="table table-striped table-sm table-bordered">                                             
                            <thead class="table-primary">                                      
                                <tr>
                                    <th></th>                                                                              
                                    <th class="cellule">Locaux raccordables</th>
                                    <th class="cellule">Catégorie</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr>   
                                    <td class="cellule premier">     
                                        <ul>
                                            <li v-bind:key="ftthdepartement.trimestre" v-for="ftthdepartement in ftthdepartements">
                                                {{ftthdepartement.trimestre}} {{ftthdepartement.annee}} 
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">   
                                        <ul>
                                            <li v-bind:key="ftthdepartement.trimestre" v-for="ftthdepartement in ftthdepartements">
                                                {{ftthdepartement.nombre_locaux}}
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">     
                                        <ul>
                                            <li v-bind:key="ftthdepartement.trimestre" v-for="ftthdepartement in ftthdepartements">
                                                {{ftthdepartement.categorie}}
                                            </li>
                                        </ul> 
                                    </td>
                                </tr>          
                            </tbody>
                        </table> 

                        <div class="row">
                            <div class="col-xl-4 col-md-4 carte">
                            </div>                            
                            <div class="col-xl-4 col-md-4 liste">Liste des epci
                                <ul>
                                    <li v-bind:key="epci" v-for="epci in orderBy(epcis, 'nom_epci')">
                                        <router-link class="" v-bind:to="`/epci/${epci.id}`">{{epci.nom_epci}}</router-link>
                                    </li>
                                </ul> 
                            </div>
                            <div class="col-xl-4 col-md-4 liste">Liste des communes
                                <ul>
                                    <li v-bind:key="commune" v-for="commune in communes">
                                        <router-link class="" v-bind:to="`/commune/${commune.id}`">{{commune.nom_commune}}</router-link>
                                    </li>
                                </ul> 
                            </div>
                        </div>

                    </div>
                    <router-link class="" v-bind:to="`/departement/${departement.id}/chart`">Voir le graphique</router-link>
                    <div class="card-footer">
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                        <router-link class=""  v-bind:to="`/region/${region.id}`"><button type="button" class="btn btn-primary">Retour à la région {{region.nom_region}}</button></router-link> 
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
  
<script>
    import axios from 'axios'


    export default {
      
        name: 'Departement',
        data () {
            return {
                departement: {},
                ftthdepartements: {},
                region: {},
                communes: {},
                epci: {}
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/departements/'+ this.id)
            .then(response => {
                // console.log(response)
                this.departement = response.data
                console.log(response.data)
                this.ftthdepartements = response.data.ftthdepartements
                // console.log(this.ftthdepartements)
                this.region = response.data.region
                this.communes = response.data.communes
                this.epcis = response.data.epci
                console.log(this.epcis)
                document.getElementById("loadingIndicatorCtn").style.display = 'none';
                
            })
            .catch(Err => {
                // console.log(err)
            })         
        },
    }
    
   
</script>

<style scoped>

</style>