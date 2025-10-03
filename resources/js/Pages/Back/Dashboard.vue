

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout >
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-4 h-full px-6 grid grid-cols-5 flex justify-stretch items-center grid-rows-[auto,1fr]">
            <div id="chart_lineMix" class="mr-3 md:pt-7 pt-1     bg-white md:col-span-3 md:row-span-2 col-span-5 row-span-1 w-full shadow-xl shadow-sky-200 rounded-lg h-full">
            </div>
            <div id="chart_basic" class="md:ml-2 mb-1 md:mt-0 mt-3 bg-white md:col-span-2 col-span-5 w-full shadow-xl shadow-sky-200 rounded-lg h-full "></div>
            <div id="chart_blue_circle" class="md:ml-2 md:mt-0 mt-3 bg-white md:col-span-1 col-span-5 shadow-xl shadow-sky-200 rounded-lg h-full"></div>
            <div id="chart_cercle" class="md:ml-2 md:mt-0 mt-5 w-full bg-white md:col-span-1 col-span-5 shadow-xl shadow-sky-200 rounded-lg h-full"></div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ApexCharts from 'apexcharts'
import { onMounted } from 'vue';
var options_cercle = {
    series: [44, 55, 67, 83],
    chart: {
    height: 350,
    type: 'radialBar',
},
plotOptions: {
    radialBar: {
    dataLabels: {
        name: {
        fontSize: '22px',
        },
        value: {
        fontSize: '16px',
        },
        total: {
        show: true,
        label: 'Total',
        formatter: function (w) {
            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
            return 249
        }
        }
    }
    }
},
labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
};
var options_blue_circle = {
    series: [76, 67, 61, 90],
    chart: {
    height: 350,
    type: 'radialBar',
},
plotOptions: {
    radialBar: {
    offsetY: 0,
    startAngle: 0,
    endAngle: 270,
    hollow: {
        margin: 5,
        size: '30%',
        background: 'transparent',
        image: undefined,
    },
    dataLabels: {
        name: {
        show: false,
        },
        value: {
        show: false,
        }
    },
    barLabels: {
        enabled: true,
        useSeriesColors: true,
        offsetX: -8,
        fontSize: '12px',
        formatter: function(seriesName, opts) {
        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
        },
    },
    }
},
colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'],
labels: ['Vimeo', 'Messenger', 'Facebook', 'LinkedIn'],
responsive: [{
    breakpoint: 480,
    options: {
    legend: {
        show: false
    }
    }
}]
};
var options_basic = {
    series: [14, 23, 21, 17, 15, 10, 12, 17, 21],
    chart: {
    type: 'polarArea',
},
stroke: {
    colors: ['#fff']
},
fill: {
    opacity: 0.8
},
responsive: [{
    breakpoint: 480,
    options: {
    chart: {
        width: 200
    },
    legend: {
        position: 'bottom'
    }
    }
}]
};
var options_lineMix = {
    series: [{
    name: 'TEAM A',
    type: 'column',
    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
}, {
    name: 'TEAM B',
    type: 'area',
    data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
}, {
    name: 'TEAM C',
    type: 'line',
    data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
}],
    chart: {
    height: 400,
    type: 'line',
    stacked: false,
},
stroke: {
    width: [0, 2, 5],
    curve: 'smooth'
},
plotOptions: {
    bar: {
    columnWidth: '50%'
    }
},

fill: {
        opacity: [0.85, 0.25, 1],
        gradient: {
        inverseColors: false,
        shade: 'light',
        type: "vertical",
        opacityFrom: 0.85,
        opacityTo: 0.55,
        stops: [0, 100, 100, 100]
    }
},
labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
    '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
],
markers: {
    size: 0
},
xaxis: {
    type: 'datetime'
},
yaxis: {
    title: {
    text: 'Points',
    }
},
tooltip: {
    shared: true,
    intersect: false,
    y: {
    formatter: function (y) {
        if (typeof y !== "undefined") {
        return y.toFixed(0) + " points";
        }
        return y;

    }
    }
}
};


onMounted(async () => {

    var chart_cercle = new ApexCharts(document.querySelector("#chart_cercle"), options_cercle);
    chart_cercle.render();

    var chart_lineMix = new ApexCharts(document.querySelector("#chart_lineMix"), options_lineMix);
    chart_lineMix.render();

    var chart_blue_circle = new ApexCharts(document.querySelector("#chart_blue_circle"), options_blue_circle);
    chart_blue_circle.render();

    var chart_basic = new ApexCharts(document.querySelector("#chart_basic"), options_basic);
    chart_basic.render();
})



      
</script>