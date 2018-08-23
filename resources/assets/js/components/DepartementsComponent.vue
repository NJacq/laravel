<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep</div>

                    <div class="card-body">
                        <ul>
                            <li v-bind:key="departement.nom_departement" v-for="departement in departements">
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
        name: 'Departements',
        data () {
            return {
                departements: {}
            }
        },
        created () {
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
