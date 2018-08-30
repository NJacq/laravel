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
                            <thead class="table-info">          
                                <tr>                                              
                                    <th>Logements</th>
                                    <th>Établissements</th>                                          
                                   
                                </tr>
                            </thead>
                            <tbody>   
                                <tr> 
                                    <td>{{departement.logements}}</td>
                                    <td>{{departement.etablissements}}</td>                                                                                       
                                </tr>          
                            </tbody>
                        </table>                   
                        <table class="table table-striped table-sm table-bordered">                                             
                            <thead class="table-info">                                      
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
                                     <td>     
                                        <ul>
                                            <li v-bind:key="ftthdepartement.trimestre" v-for="ftthdepartement in ftthdepartements">
                                                {{ftthdepartement.nombre_locaux}}
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class>     
                                        <ul>
                                            <li v-bind:key="ftthdepartement.trimestre" v-for="ftthdepartement in ftthdepartements">
                                                {{ftthdepartement.categorie}}
                                            </li>
                                        </ul> 
                                    </td>
                                </tr>          
                            </tbody>
                        </table>                                                
                    </div>
                    <router-link class="" v-bind:to="`/departement/${departement.id}/chart`">Voir le graphique</router-link>
                    <div class="card-footer">
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
                region: {}
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/departements/'+ this.id)
            .then(response => {
                // console.log(response)
                this.departement = response.data
                // console.log(this.departement)
                this.ftthdepartements = response.data.ftthdepartements
                console.log(this.ftthdepartements)
                this.region = response.data.region
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
        width: 30%;
        text-align: center;
    }
    .premier{
        text-transform: capitalize;
        font-weight: bold;
    }
</style>