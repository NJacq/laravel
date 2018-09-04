<template> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">                        
                        <p class="title">Stats arcep de la commune : {{commune.nom_commune}}</p>
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
                                    <th>Logements</th>
                                    <th>Établissements</th>                                          
                                   
                                </tr>
                            </thead>
                            <tbody>   
                                <tr> 
                                    <td>{{commune.logements}}</td>
                                    <td>{{commune.etablissements}}</td>                                                                                       
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
                                            <li v-bind:key="ftthcommune.trimestre" v-for="ftthcommune in ftthcommunes">
                                                {{ftthcommune.trimestre}} {{ftthcommune.annee}} 
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">     
                                        <ul>
                                            <li v-bind:key="ftthcommune.trimestre" v-for="ftthcommune in ftthcommunes">
                                                {{ftthcommune.locaux_raccordables}}
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">     
                                        <ul>
                                            <li v-bind:key="ftthcommune.trimestre" v-for="ftthcommune in ftthcommunes">
                                                {{ftthcommune.categorie}}
                                            </li>
                                        </ul> 
                                    </td>
                                </tr>          
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-xl-6 col-md-6 carte">
                            </div>
                            <div class="col-xl-6 col-md-6 liste">
                                <ul>
                                    <li v-bind:key="arrondissement" v-for="arrondissement in arrondissements">
                                        <router-link class="" v-bind:to="`/arrondissement/${arrondissement.id}`">{{arrondissement.nom_arrondissement}}</router-link>
                                    </li>
                                </ul> 
                            </div>
                        </div>
                                                
                    </div>
                    <!-- <router-link class="" v-bind:to="`/commune/${commune.id}/chart`">Voir le graphique</router-link> -->
                    <div class="card-footer">
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                        <router-link class=""  v-bind:to="`/departement/${commune.departement_id}`"><button type="button" class="btn btn-primary">Retour au département {{departement.nom_departement}}</button></router-link>
                        <router-link class=""  v-bind:to="`/epci/${commune.epci_id}`"><button type="button" class="btn btn-primary">Retour àl'epci {{epci.nom_epci}}</button></router-link> 
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
  
<script>
    import axios from 'axios'


    export default {
      
        name: 'Commune',
        data () {
            return {
                commune: {},
                departement: {},
                ftthcommunes:{},
                arrondissements:{},
                epci:{}
               
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/communes/'+ this.id)
            .then(response => {
                // console.log(response)
                this.commune = response.data   
                console.log(this.commune)                
                this.departement = response.data.departement
                this.ftthcommunes = response.data.ftth_communes
                // console.log(this.ftthcommunes)
                this.arrondissements = response.data.arrondissements
                this.epci = response.data.epci
                console.log(this.epci)

                document.getElementById("loadingIndicatorCtn").style.display = 'none';
                
            })
            .catch(Err => {
                // console.log(err)
            })         
        },
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
    .cellule{  
        height: 30%; 
    }
    .premier{
        text-transform: capitalize;
        font-weight: bold;
    }
</style>