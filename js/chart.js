/**
 * Helper method to retrieve numeric form of computed style.
 * @author Austin Houck <akh4rf@virginia.edu>
 * @param {HTMLElement} el The element being referenced
 * @param {string} attr The desired attribute
 * @returns number
 */
function getStyleFloat(el, attr) {
  return parseFloat(window.getComputedStyle(el)[attr]);
}

/***
 * A method to plot the chart's data, with each player's data being plotted on a separate layer.
 * @author Austin Houck <akh4rf@virginia.edu>
 * @param {number} dot_r The radius of the graph's dots, in pixels
 * @param {number} chart_border The thickness of the chart's border, in pixels
 * @param {any} stats An array of player stats, with each key mapped to an array of integers (representing points)
 * @param {number} max The maximum points value of all players
 * @returns null
 */
function drawChart(dot_r, chart_border, stats, max) {
  let layers = document.querySelectorAll(".chart-layer>div");
  let chart = new Chart(
    dot_r,
    chart_border,
    getStyleFloat(layers[0], "height"),
    getStyleFloat(layers[0], "width"),
    max,
    7
  );
  layer = 0;
  for (stat in stats) {
    chart.drawChartLayer(stats[stat], layers[layer]);
    layer++;
  }
  console.log(chart);
}

class Chart {
  constructor(dot_r, border, height, width, max, days) {
    this.dot_r = dot_r;
    this.border = border;
    this.height = height;
    this.width = width;
    this.max = max;
    this.days = days;
    this.lines = new Array();
  }

  /**
   * A method to plot a single layer of a chart.
   * @author Austin Houck <akh4rf@virginia.edu>
   * @param {Array<number>} stat An array of integers representing a single player's points over a given time period
   * @param {Element} layer The .dot-wrapper element
   * @returns null
   */
  drawChartLayer(stat, layer) {
    let line = new Line();
    line.populate(layer);
    line.drawDots(stat, this.height, this.width, this.days, this.max);
    line.connectDots(this.dot_r, this.border);
    this.lines.push(line);
  }
}

class Line {
  constructor() {
    this.lines = new Array();
    this.dots = new Array();
  }

  /**
   * A method to position the dots on a single layer of a chart.
   * @author Austin Houck <akh4rf@virginia.edu>
   * @param {Array<number>} stat An array of integers representing a single player's points over a given time period
   * @param {number} dw_h The container height
   * @param {number} dw_w The container width
   * @param {number} days The time period (in days) being plotted
   * @param {number} max The maximum points value of all players
   * @returns null
   */
  drawDots(stat, dw_h, dw_w, days, max) {
    for (let i = 0; i < this.dots.length; i++) {
      this.dots[i].style.left = -10 + dw_w * (i / (days - 1)) + "px";
      this.dots[i].style.bottom = -10 + (0.9 * dw_h * stat[i]) / max + "px";
    }
  }

  /**
   * A method to position the lines on a single layer of a chart.
   * @author Austin Houck <akh4rf@virginia.edu>
   * @param {number} dot_r The radius of the graph's dots, in pixels
   * @param {number} chart_border The thickness of the chart's border, in pixels
   * @returns null
   */
  connectDots(dot_r, chart_border) {
    for (let i = 0; i < this.lines.length; i++) {
      let x2 = getStyleFloat(this.dots[i + 1], "left"),
        x1 = getStyleFloat(this.dots[i], "left"),
        y2 = getStyleFloat(this.dots[i + 1], "bottom"),
        y1 = getStyleFloat(this.dots[i], "bottom"),
        deltaX = x2 - x1,
        deltaY = y2 - y1,
        angle = Math.atan(deltaY / deltaX),
        h = Math.sqrt(Math.pow(deltaX, 2) + Math.pow(deltaY, 2));

      this.lines[i].style.transform = "rotate(-" + angle + "rad)";
      this.lines[i].style.bottom =
        y1 + deltaY / 2 + dot_r - chart_border + "px";
      this.lines[i].style.left =
        x1 + (h * (Math.cos(angle) - 1)) / 2 + dot_r + "px";
      this.lines[i].style.width = h + "px";
    }
  }

  populate(dw_el) {
    for (let j = 0; j < dw_el.children.length; j++) {
      let child = dw_el.children[j];
      if (child.classList.contains("line")) {
        this.lines.push(child);
      } else if (child.classList.contains("dot")) {
        this.dots.push(child);
      }
    }
  }
}
