import fs from 'fs';
import path from 'path';
import { Jimp, intToRGBA } from 'jimp';

const inputs = [
  {
    file: '/mnt/c/app/website/gemini/Gemini_Generated_Image_15rt6a15rt6a15rt.png',
    prefix: 'set1',
  },
  {
    file: '/mnt/c/app/website/gemini/Gemini_Generated_Image_evht51evht51evht.png',
    prefix: 'set2',
  },
  {
    file: '/mnt/c/app/website/gemini/Gemini_Generated_Image_yftvcmyftvcmyftv.png',
    prefix: 'set3',
  },
  {
    file: '/mnt/c/app/website/gemini/Gemini_Generated_Image_z7df1hz7df1hz7df (2).png',
    prefix: 'set4',
  },
];

const outDir = '/mnt/c/app/website/agricatalog-project/public/assets/icons/categories/gemini-slices';
fs.mkdirSync(outDir, { recursive: true });

const colorDistance = (a, b) => {
  const dr = a.r - b.r;
  const dg = a.g - b.g;
  const db = a.b - b.b;
  return Math.abs(dr) + Math.abs(dg) + Math.abs(db);
};

const isBackground = (rgba, bg) => colorDistance(rgba, bg) < 30 && rgba.a > 200;

const scanComponents = async (image) => {
  const { width, height } = image.bitmap;
  const bg = intToRGBA(image.getPixelColor(0, 0));
  const visited = new Uint8Array(width * height);
  const components = [];

  const idx = (x, y) => y * width + x;

  for (let y = 0; y < height; y++) {
    for (let x = 0; x < width; x++) {
      const index = idx(x, y);
      if (visited[index]) continue;

      const rgba = intToRGBA(image.getPixelColor(x, y));
      if (isBackground(rgba, bg)) {
        visited[index] = 1;
        continue;
      }

      let minX = x;
      let maxX = x;
      let minY = y;
      let maxY = y;
      let count = 0;

      const stackX = [x];
      const stackY = [y];
      visited[index] = 1;

      while (stackX.length) {
        const cx = stackX.pop();
        const cy = stackY.pop();
        count++;

        if (cx < minX) minX = cx;
        if (cx > maxX) maxX = cx;
        if (cy < minY) minY = cy;
        if (cy > maxY) maxY = cy;

        const neighbors = [
          [cx - 1, cy],
          [cx + 1, cy],
          [cx, cy - 1],
          [cx, cy + 1],
        ];

        for (const [nx, ny] of neighbors) {
          if (nx < 0 || ny < 0 || nx >= width || ny >= height) continue;
          const nIndex = idx(nx, ny);
          if (visited[nIndex]) continue;

          const nRgba = intToRGBA(image.getPixelColor(nx, ny));
          if (isBackground(nRgba, bg)) {
            visited[nIndex] = 1;
            continue;
          }

          visited[nIndex] = 1;
          stackX.push(nx);
          stackY.push(ny);
        }
      }

      components.push({ minX, minY, maxX, maxY, count });
    }
  }

  return components;
};

const filterTiles = (components) => {
  const large = components.filter((c) => c.count > 5000);
  if (!large.length) return [];

  const widths = large.map((c) => c.maxX - c.minX + 1).sort((a, b) => a - b);
  const heights = large.map((c) => c.maxY - c.minY + 1).sort((a, b) => a - b);
  const mid = Math.floor(widths.length / 2);
  const medianW = widths[mid];
  const medianH = heights[mid];

  return large.filter((c) => {
    const w = c.maxX - c.minX + 1;
    const h = c.maxY - c.minY + 1;
    return (
      w > medianW * 0.7 &&
      w < medianW * 1.3 &&
      h > medianH * 0.7 &&
      h < medianH * 1.3
    );
  });
};

const sortTiles = (tiles) =>
  tiles.slice().sort((a, b) => (a.minY - b.minY) || (a.minX - b.minX));

const padBox = (tile, pad, width, height) => {
  const x = Math.max(0, tile.minX - pad);
  const y = Math.max(0, tile.minY - pad);
  const w = Math.min(width - x, tile.maxX - tile.minX + 1 + pad * 2);
  const h = Math.min(height - y, tile.maxY - tile.minY + 1 + pad * 2);
  return { x, y, w, h };
};

const run = async () => {
  for (const input of inputs) {
    const image = await Jimp.read(input.file);
    const components = await scanComponents(image);
    const tiles = sortTiles(filterTiles(components));

    if (!tiles.length) {
      console.log(`No tiles found for ${input.file}`);
      continue;
    }

    console.log(`${input.prefix}: ${tiles.length} tiles`);

    const { width, height } = image.bitmap;

    for (let i = 0; i < tiles.length; i++) {
      const tile = tiles[i];
      const { x, y, w, h } = padBox(tile, 2, width, height);
      const outName = `${input.prefix}-${String(i + 1).padStart(2, '0')}.png`;
      const outPath = path.join(outDir, outName);
      try {
        const cropped = image.clone().crop({ x, y, w, h });
        await cropped.write(outPath);
        console.log(`  -> ${outName}`);
      } catch (err) {
        console.error(`Failed to write ${outName}`, err);
      }
    }
  }
};

run().catch((err) => {
  console.error(err);
  process.exit(1);
});
