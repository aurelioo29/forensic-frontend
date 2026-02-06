import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

/**
 * Global password features
 * Usage:
 * - wrapper: data-pw
 * - input:   .password-input
 * - toggle:  data-pw-toggle
 * - icons:   data-eye-open / data-eye-closed (optional)
 * - caps:    data-caps-warning (optional)
 * - meter:   data-strength-meter + data-strength-bar + data-strength-text (optional)
 */
function initPasswordFeatures(root = document) {
    root.querySelectorAll("[data-pw]").forEach((wrap) => {
        const input = wrap.querySelector(".password-input");
        const toggle = wrap.querySelector("[data-pw-toggle]");
        if (!input || !toggle) return;

        // avoid double-binding
        if (wrap.dataset.pwBound === "1") return;
        wrap.dataset.pwBound = "1";

        const eyeOpen = toggle.querySelector("[data-eye-open]");
        const eyeClosed = toggle.querySelector("[data-eye-closed]");
        const caps = wrap.querySelector("[data-caps-warning]");
        const meter = wrap.querySelector("[data-strength-meter]");
        const bar = wrap.querySelector("[data-strength-bar]");
        const text = wrap.querySelector("[data-strength-text]");

        // -------------------------
        // Show / Hide password
        // -------------------------
        const setVisibility = (show) => {
            input.type = show ? "text" : "password";
            toggle.setAttribute("aria-pressed", show ? "true" : "false");
            toggle.setAttribute(
                "aria-label",
                show ? "Hide password" : "Show password",
            );

            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle("hidden", show);
                eyeClosed.classList.toggle("hidden", !show);
            }
        };
        setVisibility(false);

        toggle.addEventListener("click", () => {
            setVisibility(input.type === "password");
        });

        // -------------------------
        // Caps lock detection
        // -------------------------
        if (caps) {
            const updateCaps = (e) => {
                caps.classList.toggle(
                    "hidden",
                    !e.getModifierState("CapsLock"),
                );
            };

            input.addEventListener("keydown", updateCaps);
            input.addEventListener("keyup", updateCaps);
            input.addEventListener("blur", () => caps.classList.add("hidden"));
        }

        // -------------------------
        // Password strength meter (INLINE COLOR, anti purge)
        // -------------------------
        const levels = [
            { label: "Very weak", color: "#ef4444" }, // red-500
            { label: "Weak", color: "#f97316" }, // orange-500
            { label: "Okay", color: "#eab308" }, // yellow-500
            { label: "Strong", color: "#22c55e" }, // green-500
        ];

        const calcLevel = (val) => {
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            return Math.max(score, 1); // 1..4
        };

        const renderStrength = () => {
            if (!meter || !bar || !text) return;

            const val = input.value || "";
            if (!val) {
                meter.classList.add("hidden");
                bar.style.width = "0%";
                bar.style.backgroundColor = "transparent";
                text.textContent = "";
                return;
            }

            const level = calcLevel(val); // 1..4
            const idx = level - 1;

            meter.classList.remove("hidden");
            bar.style.width = (level / 4) * 100 + "%";
            bar.style.backgroundColor = levels[idx].color;
            text.textContent = levels[idx].label;
        };

        input.addEventListener("input", renderStrength);
        renderStrength();

        // -------------------------
        // Auto-hide when submit
        // -------------------------
        const form = input.closest("form");
        if (form) {
            form.addEventListener("submit", () => {
                setVisibility(false);
            });
        }
    });
}

document.addEventListener("DOMContentLoaded", () => initPasswordFeatures());
document.addEventListener("livewire:navigated", () => initPasswordFeatures());
document.addEventListener("turbo:load", () => initPasswordFeatures());
