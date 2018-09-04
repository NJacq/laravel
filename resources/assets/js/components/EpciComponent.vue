<template> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">                        
                        <p class="title">Stats arcep de l'epci : {{epci.nom_epci}}</p>
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
                                    <td>{{epci.logements}}</td>
                                    <td>{{epci.etablissements}}</td>                                                                                       
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
                                            <li v-bind:key="ftthepc.trimestre" v-for="ftthepc in ftthepci">
                                                {{ftthepc.trimestre}} {{ftthepc.annee}} 
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td>     
                                        <ul>
                                            <li v-bind:key="ftthepc.trimestre" v-for="ftthepc in ftthepci">
                                                {{ftthepc.nombre_locaux}}
                                            </li>
                                        </ul> 
                                    </td> 
                                     <td class>     
                                        <ul>
                                            <li v-bind:key="ftthepc.trimestre" v-for="ftthepc in ftthepci">
                                                {{ftthepc.categorie}}
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
                                    <li v-bind:key="commune" v-for="commune in communes">
                                        <router-link class="" v-bind:to="`/commune/${commune.id}`">{{commune.nom_commune}}</router-link>
                                    </li>
                                </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link>
                        <router-link class=""  v-bind:to="`/departement/${epci.departement_id}`"><button type="button" class="btn btn-primary">Retour au département {{departement.nom_departement}}</button></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
  
<script>
    import axios from 'axios'


    export default {
      
        name: 'Epci',
        data () {
            return {
                epci: {},
                communes:{}, 
                ftthepci: {},
                departement:{}                             
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/epci/'+ this.id)
            .then(response => {
                // console.log(response)
                this.epci = response.data
                // console.log(this.epci)
                this.ftthepci = response.data.ftthepci
                console.log(this.ftthepci)
                this.communes = response.data.communes
                this.departement = response.data.departement
                // console.log(this.departement)
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
    .size{
        height: 70px;
    }
</style>