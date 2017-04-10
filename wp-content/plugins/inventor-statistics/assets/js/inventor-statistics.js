jQuery(document).ready(function($) {
    'use strict';

    if ($('#chart-category svg').length !== 0) {
        categories();
    }

    if ($('#chart-listing-type svg').length !== 0) {
        listingTypes();
    }

    if ($('#chart-location svg').length !== 0) {
        listingLocations();
    }

    if ($('#chart-price svg').length !== 0) {
        priceFrom();
    }

    if ($('#chart-daily-filters svg').length !== 0) {
        filtersPerDay();
    }

    if ($('#chart-statistics-daily svg').length !== 0) {
        statisticsPerDay();
    }

    function categories() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-query': 'true',
                'type': 'listing_categories'
            }
        }).success(function(data) {
            nv.addGraph(function() {

                var chart = nv.models.pieChart()
                    .x(function(d) { return d.label })
                    .y(function(d) { return d.value })
                    .showLegend(true)
                    .showLabels(true);

                d3.select("#chart-category svg")
                    .datum(data)
                    .call(chart);

                return chart;
            });
        });
    }

    function listingTypes() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-query': 'true',
                'type': 'listing_type'
            }
        }).success(function(data) {
            nv.addGraph(function() {

                var chart = nv.models.pieChart()
                    .x(function(d) { return d.label })
                    .y(function(d) { return d.value })
                    .showLegend(true)
                    .showLabels(true);

                d3.select("#chart-listing-type svg")
                    .datum(data)
                    .call(chart);

                return chart;
            });
        });
    }

    function listingLocations() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-query': 'true',
                'type': 'locations'
            }
        }).success(function(data) {
            nv.addGraph(function() {

                var chart = nv.models.pieChart()
                    .x(function(d) { return d.label })
                    .y(function(d) { return d.value })
                    .showLegend(true)
                    .showLabels(true);

                d3.select("#chart-location svg")
                    .datum(data)
                    .call(chart);

                return chart;
            });
        });
    }

    function priceFrom() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-query': 'true',
                'type': 'price'
            }
        }).success(function(data) {
            nv.addGraph(function() {
                var chart = nv.models.scatterChart()
                    .showDistX(true)
                    .showDistY(true)
                    .color(d3.scale.category10().range())
                    .showLegend(true);

                chart.tooltipContent(function(key) {
                    return '<h3>' + key + '</h3>';
                });

                d3.select('#chart-price svg')
                    .datum(data)
                    .call(chart);
                nv.utils.windowResize(chart.update);

                return chart;
            });
        });
    }

    function statisticsPerDay() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-listing-views': 'true'
            }
        }).success(function(data) {

            nv.addGraph(function() {
                var chart = nv.models.lineChart()
                    .showLegend(false)
                    .x(function(d) { return d[0] })
                    .y(function(d) { return d[2] })
                    .showYAxis(true)
                    .showXAxis(true)
                    .forceY([0, 1])
                    .useInteractiveGuideline(false);

                chart.xAxis.tickFormat(function(d) {
                    if (data[0]['values'][d] !== undefined) {
                        var date = data[0]['values'][d][1];
                        var formatted = d3.time.format("%m/%d/%y")(new Date(date));
                        return formatted;
                    }
                });

                d3.select('#chart-statistics-daily svg')
                    .datum(data)
                    .transition().duration(500)
                    .call(chart);

                nv.utils.windowResize(chart.update);
                return chart;
            });

            setInterval(function() {
                $('#chart-statistics-daily .nv-x text').each(function() {
                    $(this).attr('dy', '2em');
                });

                $('#chart-statistics-daily .nv-y text').each(function() {
                    $(this).attr('dx', '-2em');
                });
            }, 500);
        });
    }

    function filtersPerDay() {
        $.ajax({
            url: userSettings.url,
            data: {
                'api-query': 'true',
                'type': 'filters_per_day'
            }
        }).success(function(data) {

            nv.addGraph(function() {
                var chart = nv.models.lineChart()
                    .showLegend(false)
                    .x(function(d) { return d[0] })
                    .y(function(d) { return d[2] })
                    .showYAxis(true)
                    .showXAxis(true)
                    .forceY([0, 1])
                    .useInteractiveGuideline(false);

                chart.xAxis.tickFormat(function(d) {
                    if (data[0]['values'][d] !== undefined) {
                        var date = data[0]['values'][d][1];
                        var formatted = d3.time.format("%m/%d/%y")(new Date(date));
                        return formatted;
                    }
                });

                d3.select('#chart-daily-filters svg')
                    .datum(data)
                    .transition().duration(500)
                    .call(chart);

                nv.utils.windowResize(chart.update);
                return chart;
            });

            setInterval(function() {
                $('#chart-daily-filters .nv-x text').each(function() {
                    $(this).attr('dy', '2em');
                });

                $('#chart-daily-filters .nv-y text').each(function() {
                    $(this).attr('dx', '-2em');
                });
            }, 500);
        });
    }
});