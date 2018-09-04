<template> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">                        
                        <p class="title">Stats arcep de l'arrondissement : {{arrondissement.nom_arrondissement}}</p>
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
                                    <td>{{arrondissement.logements}}</td>
                                    <td>{{arrondissement.etablissements}}</td>                                                                                       
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
                                            <li v-bind:key="fttharrondissement.trimestre" v-for="fttharrondissement in fttharrondissements">
                                                {{fttharrondissement.trimestre}} {{fttharrondissement.annee}} 
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">     
                                        <ul>
                                            <li v-bind:key="fttharrondissement.trimestre" v-for="fttharrondissement in fttharrondissements">
                                                {{fttharrondissement.locaux_raccordables}}
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class="cellule">     
                                        <ul>
                                            <li v-bind:key="fttharrondissement.trimestre" v-for="fttharrondissement in fttharrondissements">
                                                {{fttharrondissement.categorie}}
                                            </li>
                                        </ul> 
                                    </td>
                                </tr>          
                            </tbody>
                        </table>

                       
                                                
                    </div>
                    <router-link class="" v-bind:to="`/arrondissement/${arrondissement.id}/chart`">Voir le graphique</router-link>
                     <div class="card-footer">                        
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                        <router-link class=""  v-bind:to="`/commune/${arrondissement.commune_id}`"><button type="button" class="btn btn-primary">Retour à la commune {{commune.nom_commune}}</button></router-link> 
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
  
<script>
    import axios from 'axios'


    export default {
      
        name: 'Arrondissement',
        data () {
            return {                
                arrondissement:{},
                fttharrondissements:{},
                commune:{}
               
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/arrondissements/'+ this.id)
            .then(response => {                
                this.arrondissement = response.data
                console.log(this.arrondissement)
                this.commune =response.data.commune
                console.log(this.commune)
                this.fttharrondissements = response.data.fttharrondissements
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