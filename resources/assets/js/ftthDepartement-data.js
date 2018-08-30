export const ftthDepartementData = {
  type: 'bar',
  data: {
    labels: ['Trimestre 3 2017', 'Trimestre 4 2017', 'Trimestre 1 2018'],
    datasets: [
      { // one line graph
        label: 'Locaux Raccordables',    
        data: [106868, 112817,116403],
        backgroundColor: [
          'rgba(54,83,93,.5)', // Blue
          'rgba(54,83,93,.5)',
          'rgba(54,83,93,.5)',
          
              ],
        borderColor: [
          'blue',
          'blue',
          'blue',
                    ],
        borderWidth: 3
      },
      { // another line graph
        label: 'Logements',          
        data: [298064, 298064, 298064],
        backgroundColor: [
          'rgba(255, 0, 0, 0.5)', //red
          'rgba(255, 0, 0, 0.5)',
          'rgba(255, 0, 0, 0.5)',            
        ],
        borderColor: [
          'red',
          'red',
          'red',
        ],
        borderWidth: 3
      },
      { // another line graph
        label: 'Etablissements',
        data: [16129, 16129, 16129],
        backgroundColor: [
          'rgba(220, 220, 30, 0.5)', //red
          'rgba(220, 220, 30, 0.5)',
          'rgba(220, 220, 30, 0.5)',
        ],
        borderColor: [
          'yellow',
          'yellow',
          'yellow',
        ],
        borderWidth: 3
      }
    ]
  },
  options: {
    responsive: true,
    lineTension: 1,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          padding: 25,
        }
      }]
    }
  }
}

export default ftthDepartementData;
