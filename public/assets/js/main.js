/**
 * Modal manual — pengganti Bootstrap modal.
 * Trigger: <button data-modal-open="idModal">
 * Tutup:   <button data-modal-close> (di dalam modal) atau klik overlay
 */
document.addEventListener("click", function (e) {
  const opener = e.target.closest("[data-modal-open]");
  if (opener) {
    const modal = document.getElementById(opener.dataset.modalOpen);
    if (modal) modal.classList.add("is-open");
  }

  if (
    e.target.closest("[data-modal-close]") ||
    e.target.classList.contains("modal-overlay")
  ) {
    const modal = e.target.closest(".modal-overlay");
    if (modal) modal.classList.remove("is-open");
  }
});

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    document
      .querySelectorAll(".modal-overlay.is-open")
      .forEach((m) => m.classList.remove("is-open"));
  }
});

/**
 * Upload dropzone generic — dipakai di semua form dengan struktur:
 * <div class="upload-dropzone">
 *   <input type="file" hidden>
 *   <div class="upload-preview-wrap"><img><div class="upload-preview-overlay">Ganti Gambar</div></div>
 *   <div class="upload-dropzone-inner">...</div>
 *   <p class="upload-filename"></p>
 * </div>
 */
function initUploadDropzone(zone) {
  const input = zone.querySelector('input[type="file"]');
  const previewWrap = zone.querySelector(".upload-preview-wrap");
  const previewImg = zone.querySelector(".upload-preview-wrap img");
  const filenameEl = zone.querySelector(".upload-filename");

  function showPreview(file) {
    if (!file || !file.type.startsWith("image/")) return;
    const reader = new FileReader();
    reader.onload = (e) => {
      if (previewImg) previewImg.src = e.target.result;
      if (previewWrap) previewWrap.classList.add("is-active");
      zone.classList.add("has-preview");
      if (filenameEl) filenameEl.textContent = file.name;
    };
    reader.readAsDataURL(file);
  }

  zone.addEventListener("click", () => input.click());

  input.addEventListener("change", () => {
    if (input.files && input.files[0]) showPreview(input.files[0]);
  });

  ["dragover", "dragenter"].forEach((evt) => {
    zone.addEventListener(evt, (e) => {
      e.preventDefault();
      zone.classList.add("is-dragover");
    });
  });
  ["dragleave", "dragend", "drop"].forEach((evt) => {
    zone.addEventListener(evt, (e) => {
      e.preventDefault();
      zone.classList.remove("is-dragover");
    });
  });
  zone.addEventListener("drop", (e) => {
    const file = e.dataTransfer.files[0];
    if (file) {
      input.files = e.dataTransfer.files;
      showPreview(file);
    }
  });
}

document.querySelectorAll(".upload-dropzone").forEach(initUploadDropzone);

/**
 * Toggle sidebar admin (mobile off-canvas) dan navbar user (dropdown).
 * Trigger: [data-sidebar-toggle] untuk sidebar admin, [data-topnav-toggle] untuk navbar user.
 */
document.addEventListener("click", function (e) {
  if (e.target.closest("[data-sidebar-toggle]")) {
    document.querySelector(".admin-sidebar")?.classList.toggle("is-open");
    document.querySelector(".sidebar-backdrop")?.classList.toggle("is-open");
  }
  if (e.target.classList.contains("sidebar-backdrop")) {
    document.querySelector(".admin-sidebar")?.classList.remove("is-open");
    e.target.classList.remove("is-open");
  }
  if (e.target.closest("[data-topnav-toggle]")) {
    document.querySelector(".topnav-links")?.classList.toggle("is-open");
  }
});
