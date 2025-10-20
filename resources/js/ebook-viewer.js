// Worker untuk PDF.js
pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".show-pdf");
    const tableSection = document.getElementById("ebook-table-section");
    const container = document.getElementById("pdf-viewer-container");
    const closeBtn = document.getElementById("close-pdf");
    const pdfPages = document.getElementById("pdf-pages");

    let currentPdf = null;

    // ===== Fungsi render semua halaman PDF =====
    async function renderAllPages(pdf) {
        pdfPages.innerHTML = ""; // hapus tampilan sebelumnya
        const total = pdf.numPages;

        for (let i = 1; i <= total; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 1.5 });
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({ canvasContext: ctx, viewport }).promise;
            pdfPages.appendChild(canvas);
        }
    }

    // ===== Buka PDF =====
    links.forEach((link) => {
        link.addEventListener("click", async (e) => {
            e.preventDefault();

            const pdfUrl = link.dataset.url;

            // Tutup PDF sebelumnya jika ada
            if (currentPdf) {
                await currentPdf.destroy();
                currentPdf = null;
            }

            // Reset tampilan
            pdfPages.innerHTML = "";
            tableSection.classList.add("hidden");
            container.classList.remove("hidden");

            try {
                currentPdf = await pdfjsLib.getDocument(pdfUrl).promise;
                await renderAllPages(currentPdf);
                alert("⚠️ Jangan tinggalkan tab ini selama membaca eBook.");
            } catch (error) {
                alert("Gagal memuat PDF.");
                console.error(error);
                container.classList.add("hidden");
                tableSection.classList.remove("hidden");
            }
        });
    });

    // ===== Tutup PDF =====
    closeBtn.addEventListener("click", async () => {
        if (currentPdf) {
            await currentPdf.destroy();
            currentPdf = null;
        }
        pdfPages.innerHTML = "";
        container.classList.add("hidden");
        tableSection.classList.remove("hidden");
    });

    // ===== Blokir Klik Kanan & Copy =====
    document.addEventListener("contextmenu", (e) => e.preventDefault());
    document.addEventListener("keydown", (e) => {
        if (
            (e.ctrlKey && ["s", "S", "c", "C", "p", "P"].includes(e.key)) ||
            e.key === "PrintScreen"
        ) {
            e.preventDefault();
            alert("Fungsi ini dinonaktifkan untuk melindungi eBook.");
        }
    });

    // ===== Warning Saat Pindah Tab =====
    document.addEventListener("visibilitychange", () => {
        if (document.hidden && !container.classList.contains("hidden")) {
            alert("⚠️ Jangan meninggalkan tab ini saat membaca eBook!");
        }
    });

    // ===== Konfirmasi sebelum hapus eBook =====
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault(); // hentikan submit default
            const confirmed = confirm(
                "⚠️ Apakah kamu yakin ingin menghapus eBook ini?"
            );
            if (confirmed) {
                form.submit(); // submit jika user tekan OK
            }
        });
    });

    // ===== Flash message auto hide =====
    const flashMessage = document.getElementById("flash-message");
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.classList.add(
                "opacity-0",
                "transition",
                "duration-700"
            );
            setTimeout(() => flashMessage.remove(), 700);
        }, 3000); // tampil 3 detik
    }
});
