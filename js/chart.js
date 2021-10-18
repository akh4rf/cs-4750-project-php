function connectDots(lines, dots, dot_r, chart_border) {
  for (let i = 0; i < lines.length; i++) {
    let x2 = parseFloat(window.getComputedStyle(dots[i + 1]).left),
      x1 = parseFloat(window.getComputedStyle(dots[i]).left),
      y2 = parseFloat(window.getComputedStyle(dots[i + 1]).bottom),
      y1 = parseFloat(window.getComputedStyle(dots[i]).bottom),
      deltaX = x2 - x1,
      deltaY = y2 - y1,
      angle = Math.atan(deltaY / deltaX),
      h = Math.sqrt(Math.pow(deltaX, 2) + Math.pow(deltaY, 2));

    lines[i].style.transform = "rotate(-" + angle + "rad)";
    lines[i].style.bottom = y1 + deltaY / 2 + dot_r - chart_border + "px";
    lines[i].style.left = x1 + (h * (Math.cos(angle) - 1)) / 2 + dot_r + "px";
    lines[i].style.width = h + "px";
  }
}

function drawDots(dots, dw_h, dw_w, days, stat, max) {
  for (let i = 0; i < dots.length; i++) {
    dots[i].style.left = -10 + dw_w * (i / (days - 1)) + "px";
    dots[i].style.bottom = -10 + (0.9 * dw_h * stat[i]) / max + "px";
  }
}

function drawChartLayer(dot_r, chart_border, stat, layer, max) {
  let lines = Array(),
    dots = Array();
  for (let j = 0; j < layer.children.length; j++) {
    if (layer.children[j].classList.contains("line")) {
      lines.push(layer.children[j]);
    } else if (layer.children[j].classList.contains("dot")) {
      dots.push(layer.children[j]);
    }
  }
  let dw_h = parseFloat(window.getComputedStyle(layer).height),
    dw_w = parseFloat(window.getComputedStyle(layer).width);
  drawDots(dots, dw_h, dw_w, 7, stat, max);
  connectDots(lines, dots, dot_r, chart_border);
}

function drawChart(dot_r, chart_border, stats, max) {
  let layers = document.querySelectorAll(".chart-layer>div");
  layer = 0;
  for (stat in stats) {
    drawChartLayer(dot_r, chart_border, stats[stat], layers[layer], max);
    layer++;
  }
}
