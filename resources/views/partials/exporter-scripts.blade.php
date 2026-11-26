<!-- PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<!-- Excel real (.xlsx / .xls) -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>

<script>
    window.TungasucaExporter = {
        // Carga la imagen del escudo y la convierte a Base64 para embed en jsPDF
        async getLogoBase64() {
            return new Promise((resolve) => {
                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.src = '/images/escudo-tungasuca.png';
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                img.onerror = () => resolve(null);
            });
        },

        // Limpieza profunda de caracteres invisibles, iconos y emojis
        cleanText(str) {
            if (!str) return '';
            return str
                .replace(/[\u{1F300}-\u{1FAFF}\u{2600}-\u{27BF}\u{1F600}-\u{1F64F}\u{1F680}-\u{1F6FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}]/gu, '')
                .replace(/[^\x20-\x7E\xA0-\xFF\u0100-\u017F]/g, '') // Elimina caracteres Unicode no compatibles con Helvetica estándar
                .replace(/↳|└|🕒|🟢|🟡|🔴|📦|🏫/g, '')
                .replace(/\s+/g, ' ')
                .trim();
        },

        extractFromTable(tableSelector, excludeCols = [], options = {}) {
            const table = document.querySelector(tableSelector);
            if (!table) return { headers: [], rows: [] };

            const { groupedByHeaderRow = false, groupPrefix = '' } = options;

            const headers = [];
            table.querySelectorAll('thead th').forEach((th, idx) => {
                if (!excludeCols.includes(idx)) {
                    headers.push(this.cleanText(th.textContent));
                }
            });

            if (groupedByHeaderRow) {
                headers.unshift(groupPrefix || 'Aula / Sección');
            }

            const rows = [];
            let currentGroup = 'Sin Asignar';

            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.classList.contains('hidden')) return;

                const tds = Array.from(tr.querySelectorAll('td'));
                if (tds.length === 0) return;

                // Fila de encabezado de Aula (colspan)
                if (tds.length === 1 && tds[0].hasAttribute('colspan')) {
                    if (groupedByHeaderRow) {
                        currentGroup = this.cleanText(tds[0].textContent)
                            .replace(/Aula\s*:\s*/gi, '')
                            .replace(/Aula\s*\/\s*Sección\s*:\s*/gi, '')
                            .trim() || 'Sin Asignar';
                    }
                    return;
                }

                const row = [];
                if (groupedByHeaderRow) {
                    row.push(currentGroup);
                }

                tds.forEach((td, idx) => {
                    if (!excludeCols.includes(idx)) {
                        row.push(this.cleanText(td.textContent));
                    }
                });

                if (row.length > (groupedByHeaderRow ? 1 : 0)) {
                    rows.push(row);
                }
            });

            return { headers, rows };
        },

        async exportPDF({ title = 'Inventario de Mobiliario por Aula', subtitle = 'I.E. Tungasuca', filename = 'Reporte_Tungasuca.pdf', headers = [], rows = [] }) {
            if (!window.jspdf || !window.jspdf.jsPDF) {
                alert('No se cargó la librería jsPDF.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();

            // Fondo Azul Institucional del Header
            doc.setFillColor(7, 86, 163);
            doc.rect(0, 0, pageWidth, 28, 'F');

            // Cargar y agregar el Escudo de la I.E. Tungasuca
            const logoData = await this.getLogoBase64();
            if (logoData) {
                doc.addImage(logoData, 'PNG', 12, 4, 20, 20);
            }

            // Textos del Encabezado
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('I.E. TUNGASUCA', pageWidth / 2, 12, { align: 'center' });

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(`${title} — ${subtitle}`, pageWidth / 2, 19, { align: 'center' });

            const fecha = new Date().toLocaleDateString('es-PE', {
                day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
            doc.setFontSize(8);
            doc.text(`Generado: ${fecha}`, pageWidth - 12, 24, { align: 'right' });

            if (!rows.length) {
                doc.setTextColor(100);
                doc.setFontSize(12);
                doc.text('No hay registros disponibles para exportar.', pageWidth / 2, 55, { align: 'center' });
                doc.save(filename);
                return;
            }

            doc.autoTable({
                startY: 33,
                head: [headers],
                body: rows,
                theme: 'grid',
                styles: {
                    font: 'helvetica',
                    fontSize: 8.5,
                    cellPadding: 3,
                    textColor: [23, 43, 77],
                    lineColor: [203, 213, 225],
                    lineWidth: 0.2,
                },
                headStyles: {
                    fillColor: [7, 86, 163],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    halign: 'center',
                    fontSize: 9,
                },
                alternateRowStyles: {
                    fillColor: [248, 250, 252],
                },
                columnStyles: {
                    0: { cellWidth: 35, fontStyle: 'bold', textColor: [7, 86, 163] }, // Aula / Sección
                    1: { cellWidth: 'auto' }, // Objeto / Mobiliario
                    2: { cellWidth: 50, halign: 'center' }, // Cantidad y Estado
                    3: { cellWidth: 45, halign: 'center' }  // Fecha y Hora
                }
            });

            // Pie de Página
            const totalPaginas = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPaginas; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(120);
                doc.text(
                    `Página ${i} de ${totalPaginas} | I.E. Tungasuca - Sistema de Gestión Escolar`,
                    pageWidth / 2,
                    pageHeight - 7,
                    { align: 'center' }
                );
            }

            doc.save(filename);
        },

        exportCSV({ filename = 'Reporte_Tungasuca.csv', headers = [], rows = [] }) {
            const esc = (val) => {
                const s = String(val ?? '').trim();
                return (s.includes(',') || s.includes(';') || s.includes('"') || s.includes('\n'))
                    ? `"${s.replace(/"/g, '""')}"`
                    : s;
            };

            const lines = [headers, ...rows].map(r => r.map(esc).join(','));
            const blob = new Blob(['\uFEFF' + lines.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        },

        exportExcel({ sheetName = 'Inventario', filename = 'Reporte_Tungasuca.xlsx', ext = 'xlsx', headers = [], rows = [] }) {
            if (typeof XLSX === 'undefined') {
                alert('No se cargó la librería de Excel (SheetJS).');
                return;
            }

            const aoa = [headers, ...rows];
            const worksheet = XLSX.utils.aoa_to_sheet(aoa);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, sheetName.slice(0, 31));

            const bookType = ext === 'xls' ? 'xls' : 'xlsx';
            const finalName = filename.replace(/\.(xlsx|xls)$/i, '') + '.' + bookType;
            XLSX.writeFile(workbook, finalName, { bookType });
        },

        async run(formato, config) {
            const baseName = (config.filename || 'Reporte_Tungasuca').replace(/\.(pdf|csv|xlsx|xls)$/i, '');
            if (formato === 'pdf') {
                return await this.exportPDF({ ...config, filename: baseName + '.pdf' });
            }
            if (formato === 'csv') {
                return this.exportCSV({ ...config, filename: baseName + '.csv' });
            }
            if (formato === 'xlsx' || formato === 'xls') {
                return this.exportExcel({ ...config, filename: baseName + '.' + formato, ext: formato });
            }
        }
    };
</script>