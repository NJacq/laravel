<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep de la région {{region.nom_region}}</div>

                    <div class="card-body">
                        <table class="table table-sm table-hover">                 
                            <thead class="thead-dark">           
                                <tr>
                                    <th>Nom de la région</th>              
                                    <th>Numéro de la région</th>
                                    <th>Logements</th>
                                    <th>Établissements</th>
                                </tr>
                            </thead>
                            <tbody>   
                                <tr>                             
                                    <td>{{region.nom_region}}</td>
                                    <td>{{region.code_region}}</td>
                                    <td>{{region.logements}}</td>
                                    <td>{{region.etablissements}}</td>
                                </tr>          
                            </tbody>
                        </table>
                         <ul>
                            <li v-bind:key="departement.nom_departement" v-for="departement in filterBy (departements, region.code_region, 'code_region') ">
                                <router-link class="" v-bind:to="`/departement/${departement.id}`">{{departement.nom_departement}}</router-link> 
                            </li>
                        </ul>
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
                departements : {}
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/regions/'+ this.id)
            .then(response => {
                console.log(response)
                this.region = response.data
                // this.comp = JSON.parse(response.data)
            })
            .catch(Err => {
                // console.log(err)
            }),            
            axios.get('http://localhost:8000/api/departements')
            .then(response => {
                console.log(response)
                this.departements = response.data
                // this.comp = JSON.parse(response.data)
            })
            .catch(Err => {
                // console.log(err)
            })
        }
    }
</script>

