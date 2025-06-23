<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Mini Chat</title>

    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg viewBox='0 -.11376601 49.74245785 51.31690859' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1 -.402.694l-9.209 5.302v10.509c0 .286-.152.55-.4.694l-19.223 11.066c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1 -.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054l-19.219-11.066a.801.801 0 0 1 -.402-.694v-32.916c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216zm-36.84-31.068v31.068l17.618 10.143v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-21.483l-4.645-2.676-3.363-1.934zm8.81-5.994-8.007 4.609 8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764 4.645-2.674v-20.096l-3.363 1.936-4.646 2.675v20.096zm24.667-23.325-8.006 4.609 8.006 4.609 8.005-4.61zm-.801 10.605-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937zm-18.422 20.561 11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833z' fill='%23ff2d20'/%3E%3C/svg%3E" />

    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600" rel="stylesheet" />

    <style>
        .tippy-box[data-animation=fade][data-state=hidden] {
            opacity: 0
        }

        [data-tippy-root] {
            max-width: calc(100vw - 10px)
        }

        .tippy-box {
            position: relative;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.4;
            white-space: normal;
            outline: 0;
            transition-property: transform, visibility, opacity
        }

        .tippy-box[data-placement^=top]>.tippy-arrow {
            bottom: 0
        }

        .tippy-box[data-placement^=top]>.tippy-arrow:before {
            bottom: -7px;
            left: 0;
            border-width: 8px 8px 0;
            border-top-color: initial;
            transform-origin: center top
        }

        .tippy-box[data-placement^=bottom]>.tippy-arrow {
            top: 0
        }

        .tippy-box[data-placement^=bottom]>.tippy-arrow:before {
            top: -7px;
            left: 0;
            border-width: 0 8px 8px;
            border-bottom-color: initial;
            transform-origin: center bottom
        }

        .tippy-box[data-placement^=left]>.tippy-arrow {
            right: 0
        }

        .tippy-box[data-placement^=left]>.tippy-arrow:before {
            border-width: 8px 0 8px 8px;
            border-left-color: initial;
            right: -7px;
            transform-origin: center left
        }

        .tippy-box[data-placement^=right]>.tippy-arrow {
            left: 0
        }

        .tippy-box[data-placement^=right]>.tippy-arrow:before {
            left: -7px;
            border-width: 8px 8px 8px 0;
            border-right-color: initial;
            transform-origin: center right
        }

        .tippy-box[data-inertia][data-state=visible] {
            transition-timing-function: cubic-bezier(.54, 1.5, .38, 1.11)
        }

        .tippy-arrow {
            width: 16px;
            height: 16px;
            color: #333
        }

        .tippy-arrow:before {
            content: "";
            position: absolute;
            border-color: transparent;
            border-style: solid
        }

        .tippy-content {
            position: relative;
            padding: 5px 9px;
            z-index: 1
        }

        .tippy-box[data-theme~=material] {
            background-color: #505355;
            font-weight: 600
        }

        .tippy-box[data-theme~=material][data-placement^=top]>.tippy-arrow:before {
            border-top-color: #505355
        }

        .tippy-box[data-theme~=material][data-placement^=bottom]>.tippy-arrow:before {
            border-bottom-color: #505355
        }

        .tippy-box[data-theme~=material][data-placement^=left]>.tippy-arrow:before {
            border-left-color: #505355
        }

        .tippy-box[data-theme~=material][data-placement^=right]>.tippy-arrow:before {
            border-right-color: #505355
        }

        .tippy-box[data-theme~=material]>.tippy-backdrop {
            background-color: #505355
        }

        .tippy-box[data-theme~=material]>.tippy-svg-arrow {
            fill: #505355
        }

        .tippy-box[data-animation=scale][data-placement^=top] {
            transform-origin: bottom
        }

        .tippy-box[data-animation=scale][data-placement^=bottom] {
            transform-origin: top
        }

        .tippy-box[data-animation=scale][data-placement^=left] {
            transform-origin: right
        }

        .tippy-box[data-animation=scale][data-placement^=right] {
            transform-origin: left
        }

        .tippy-box[data-animation=scale][data-state=hidden] {
            transform: scale(.5);
            opacity: 0
        }

        *,
        :before,
        :after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        :before,
        :after {
            --tw-content: ""
        }

        html,
        :host {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        samp,
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        button,
        input:where([type=button]),
        input:where([type=reset]),
        input:where([type=submit]) {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dl,
        dd,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        figure,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        ol,
        ul,
        menu {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::-moz-placeholder,
        textarea::-moz-placeholder {
            opacity: 1;
            color: #9ca3af
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        button,
        [role=button] {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        img,
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        :before,
        :after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        .container {
            width: 100%
        }

        @media (min-width: 640px) {
            .container {
                max-width: 640px
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 768px
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1024px
            }
        }

        @media (min-width: 1280px) {
            .container {
                max-width: 1280px
            }
        }

        @media (min-width: 1536px) {
            .container {
                max-width: 1536px
            }
        }

        .absolute {
            position: absolute
        }

        .relative {
            position: relative
        }

        .right-0 {
            right: 0
        }

        .z-10 {
            z-index: 10
        }

        .mx-5 {
            margin-left: 1.25rem;
            margin-right: 1.25rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .my-3 {
            margin-top: .75rem;
            margin-bottom: .75rem
        }

        .-mt-2 {
            margin-top: -.5rem
        }

        .mb-12 {
            margin-bottom: 3rem
        }

        .mb-2 {
            margin-bottom: .5rem
        }

        .mb-3 {
            margin-bottom: .75rem
        }

        .ml-1 {
            margin-left: .25rem
        }

        .ml-3 {
            margin-left: .75rem
        }

        .mt-1 {
            margin-top: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mt-3 {
            margin-top: .75rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .block {
            display: block
        }

        .inline-block {
            display: inline-block
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .table {
            display: table
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .h-4 {
            height: 1rem
        }

        .h-5 {
            height: 1.25rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-\[32\.5rem\] {
            height: 32.5rem
        }

        .h-\[35\.5rem\] {
            height: 35.5rem
        }

        .max-h-32 {
            max-height: 8rem
        }

        .w-4 {
            width: 1rem
        }

        .w-5 {
            width: 1.25rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-\[8rem\] {
            width: 8rem
        }

        .w-full {
            width: 100%
        }

        .min-w-0 {
            min-width: 0px
        }

        .max-w-full {
            max-width: 100%
        }

        .flex-none {
            flex: none
        }

        .shrink-0 {
            flex-shrink: 0
        }

        .flex-grow {
            flex-grow: 1
        }

        .origin-top-right {
            transform-origin: top right
        }

        .cursor-pointer {
            cursor: pointer
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        .flex-col {
            flex-direction: column
        }

        .items-center {
            align-items: center
        }

        .items-baseline {
            align-items: baseline
        }

        .justify-between {
            justify-content: space-between
        }

        .gap-2 {
            gap: .5rem
        }

        .gap-3 {
            gap: .75rem
        }

        .gap-6 {
            gap: 1.5rem
        }

        .space-y-2>:not([hidden])~:not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(.5rem * var(--tw-space-y-reverse))
        }

        .overflow-x-auto {
            overflow-x: auto
        }

        .overflow-y-hidden {
            overflow-y: hidden
        }

        .overflow-x-scroll {
            overflow-x: scroll
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .break-words {
            overflow-wrap: break-word
        }

        .rounded {
            border-radius: .25rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .rounded-lg {
            border-radius: .5rem
        }

        .rounded-md {
            border-radius: .375rem
        }

        .rounded-r-md {
            border-top-right-radius: .375rem;
            border-bottom-right-radius: .375rem
        }

        .border {
            border-width: 1px
        }

        .border-l {
            border-left-width: 1px
        }

        .border-l-2 {
            border-left-width: 2px
        }

        .border-r {
            border-right-width: 1px
        }

        .border-t {
            border-top-width: 1px
        }

        .border-transparent {
            border-color: transparent
        }

        .border-l-red-500 {
            --tw-border-opacity: 1;
            border-left-color: rgb(239 68 68 / var(--tw-border-opacity))
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .bg-gray-200 {
            --tw-bg-opacity: 1;
            background-color: rgb(229 231 235 / var(--tw-bg-opacity))
        }

        .bg-gray-200\/80 {
            background-color: #e5e7ebcc
        }

        .bg-red-500\/20 {
            background-color: #ef444433
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .fill-red-500 {
            fill: #ef4444
        }

        .p-1 {
            padding: .25rem
        }

        .p-2 {
            padding: .5rem
        }

        .p-4 {
            padding: 1rem
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-3 {
            padding-left: .75rem;
            padding-right: .75rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .py-2 {
            padding-top: .5rem;
            padding-bottom: .5rem
        }

        .py-3 {
            padding-top: .75rem;
            padding-bottom: .75rem
        }

        .pb-12 {
            padding-bottom: 3rem
        }

        .pt-4 {
            padding-top: 1rem
        }

        .pt-6 {
            padding-top: 1.5rem
        }

        .text-left {
            text-align: left
        }

        .text-right {
            text-align: right
        }

        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace
        }

        .font-sans {
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji"
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: .875rem;
            line-height: 1.25rem
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-xs {
            font-size: .75rem;
            line-height: 1rem
        }

        .font-bold {
            font-weight: 700
        }

        .font-semibold {
            font-weight: 600
        }

        .leading-5 {
            line-height: 1.25rem
        }

        .text-blue-500 {
            --tw-text-opacity: 1;
            color: rgb(59 130 246 / var(--tw-text-opacity))
        }

        .text-gray-400 {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity))
        }

        .text-gray-50 {
            --tw-text-opacity: 1;
            color: rgb(249 250 251 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .text-red-500 {
            --tw-text-opacity: 1;
            color: rgb(239 68 68 / var(--tw-text-opacity))
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .shadow-xl {
            --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / .1), 0 8px 10px -6px rgb(0 0 0 / .1);
            --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .ring-1 {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .ring-gray-900\/5 {
            --tw-ring-color: rgb(17 24 39 / .05)
        }

        [x-cloak] {
            display: none
        }

        html {
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4
        }

        table.hljs-ln {
            color: inherit;
            font-size: inherit;
            border-spacing: 2px
        }

        pre code.hljs {
            background: none;
            padding: .5em 0 0;
            width: 100%
        }

        .hljs-ln-line {
            white-space-collapse: preserve;
            text-wrap: nowrap
        }

        .trace {
            -webkit-mask-image: linear-gradient(180deg, #000 calc(100% - 4rem), transparent)
        }

        .scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
            overflow-x: scroll
        }

        .scrollbar-hidden::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 0;
            height: 0
        }

        .hljs-ln .hljs-ln-numbers {
            padding: 5px;
            border-right-color: transparent;
            margin-right: 5px
        }

        .hljs-ln-n {
            width: 50px
        }

        .hljs-ln-numbers {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            text-align: center;
            border-right: 1px solid #ccc;
            vertical-align: top;
            padding-right: 5px
        }

        .hljs-ln-code {
            width: 100%;
            padding-left: 10px;
            padding-right: 10px
        }

        .hljs-ln-code:hover {
            background-color: #ef444433
        }

        .default\:col-span-full:default {
            grid-column: 1 / -1
        }

        .default\:row-span-1:default {
            grid-row: span 1 / span 1
        }

        .hover\:rounded-b-md:hover {
            border-bottom-right-radius: .375rem;
            border-bottom-left-radius: .375rem
        }

        .hover\:rounded-t-md:hover {
            border-top-left-radius: .375rem;
            border-top-right-radius: .375rem
        }

        .hover\:bg-gray-100:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .hover\:bg-gray-100\/75:hover {
            background-color: #f3f4f6bf
        }

        .hover\:text-gray-500:hover {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .hover\:underline:hover {
            text-decoration-line: underline
        }

        .focus\:text-gray-500:focus {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .dark\:block:is(.dark *) {
            display: block
        }

        .dark\:hidden:is(.dark *) {
            display: none
        }

        .dark\:border:is(.dark *) {
            border-width: 1px
        }

        .dark\:border-gray-700:is(.dark *) {
            --tw-border-opacity: 1;
            border-color: rgb(55 65 81 / var(--tw-border-opacity))
        }

        .dark\:border-gray-800:is(.dark *) {
            --tw-border-opacity: 1;
            border-color: rgb(31 41 55 / var(--tw-border-opacity))
        }

        .dark\:border-gray-900:is(.dark *) {
            --tw-border-opacity: 1;
            border-color: rgb(17 24 39 / var(--tw-border-opacity))
        }

        .dark\:border-l-red-500:is(.dark *) {
            --tw-border-opacity: 1;
            border-left-color: rgb(239 68 68 / var(--tw-border-opacity))
        }

        .dark\:bg-gray-800:is(.dark *) {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity))
        }

        .dark\:bg-gray-900\/80:is(.dark *) {
            background-color: #111827cc
        }

        .dark\:bg-gray-950\/95:is(.dark *) {
            background-color: #030712f2
        }

        .dark\:bg-red-500\/20:is(.dark *) {
            background-color: #ef444433
        }

        .dark\:text-gray-100:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(243 244 246 / var(--tw-text-opacity))
        }

        .dark\:text-gray-300:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity))
        }

        .dark\:text-gray-400:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity))
        }

        .dark\:text-gray-600:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .dark\:text-gray-950:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(3 7 18 / var(--tw-text-opacity))
        }

        .dark\:text-white:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .dark\:ring-1:is(.dark *) {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .dark\:ring-gray-800:is(.dark *) {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(31 41 55 / var(--tw-ring-opacity))
        }

        .dark\:hover\:bg-gray-700:hover:is(.dark *) {
            --tw-bg-opacity: 1;
            background-color: rgb(55 65 81 / var(--tw-bg-opacity))
        }

        .dark\:hover\:bg-gray-800:hover:is(.dark *) {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity))
        }

        .dark\:hover\:bg-gray-800\/75:hover:is(.dark *) {
            background-color: #1f2937bf
        }

        .dark\:hover\:text-gray-500:hover:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .dark\:focus\:text-gray-500:focus:is(.dark *) {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        @media (min-width: 640px) {
            .sm\:col-span-1 {
                grid-column: span 1 / span 1
            }

            .sm\:col-span-2 {
                grid-column: span 2 / span 2
            }

            .sm\:mt-10 {
                margin-top: 2.5rem
            }

            .sm\:gap-6 {
                gap: 1.5rem
            }

            .sm\:p-12 {
                padding: 3rem
            }

            .sm\:py-5 {
                padding-top: 1.25rem;
                padding-bottom: 1.25rem
            }

            .sm\:text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem
            }
        }

        @media (min-width: 768px) {
            .md\:block {
                display: block
            }

            .md\:inline {
                display: inline
            }

            .md\:flex {
                display: flex
            }

            .md\:hidden {
                display: none
            }

            .md\:min-w-64 {
                min-width: 16rem
            }

            .md\:max-w-80 {
                max-width: 20rem
            }

            .md\:items-center {
                align-items: center
            }

            .md\:justify-between {
                justify-content: space-between
            }

            .md\:gap-2 {
                gap: .5rem
            }
        }

        @media (min-width: 1024px) {
            .lg\:block {
                display: block
            }

            .lg\:inline-block {
                display: inline-block
            }

            .lg\:w-\[12rem\] {
                width: 12rem
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }

            .lg\:text-2xl {
                font-size: 1.5rem;
                line-height: 2rem
            }

            .lg\:text-base {
                font-size: 1rem;
                line-height: 1.5rem
            }

            .lg\:text-sm {
                font-size: .875rem;
                line-height: 1.25rem
            }

            .default\:lg\:col-span-6:default {
                grid-column: span 6 / span 6
            }
        }
    </style>
    <style data-theme="light">
        pre code.hljs {
            display: block;
            overflow-x: auto;
            padding: 1em
        }

        code.hljs {
            padding: 3px 5px
        }

        /*!
  Theme: GitHub
  Description: Light theme as seen on github.com
  Author: github.com
  Maintainer: @Hirse
  Updated: 2021-05-15

  Outdated base version: https://github.com/primer/github-syntax-light
  Current colors taken from GitHub's CSS
*/
        .hljs {
            color: #24292e;
            background: #fff
        }

        .hljs-doctag,
        .hljs-keyword,
        .hljs-meta .hljs-keyword,
        .hljs-template-tag,
        .hljs-template-variable,
        .hljs-type,
        .hljs-variable.language_ {
            color: #d73a49
        }

        .hljs-title,
        .hljs-title.class_,
        .hljs-title.class_.inherited__,
        .hljs-title.function_ {
            color: #6f42c1
        }

        .hljs-attr,
        .hljs-attribute,
        .hljs-literal,
        .hljs-meta,
        .hljs-number,
        .hljs-operator,
        .hljs-selector-attr,
        .hljs-selector-class,
        .hljs-selector-id,
        .hljs-variable {
            color: #005cc5
        }

        .hljs-meta .hljs-string,
        .hljs-regexp,
        .hljs-string {
            color: #032f62
        }

        .hljs-built_in,
        .hljs-symbol {
            color: #e36209
        }

        .hljs-code,
        .hljs-comment,
        .hljs-formula {
            color: #6a737d
        }

        .hljs-name,
        .hljs-quote,
        .hljs-selector-pseudo,
        .hljs-selector-tag {
            color: #22863a
        }

        .hljs-subst {
            color: #24292e
        }

        .hljs-section {
            color: #005cc5;
            font-weight: 700
        }

        .hljs-bullet {
            color: #735c0f
        }

        .hljs-emphasis {
            color: #24292e;
            font-style: italic
        }

        .hljs-strong {
            color: #24292e;
            font-weight: 700
        }

        .hljs-addition {
            color: #22863a;
            background-color: #f0fff4
        }

        .hljs-deletion {
            color: #b31d28;
            background-color: #ffeef0
        }
    </style>
    <style data-theme="dark">
        pre code.hljs {
            display: block;
            overflow-x: auto;
            padding: 1em
        }

        code.hljs {
            padding: 3px 5px
        }

        .hljs {
            color: #abb2bf;
            background: #282c34
        }

        .hljs-comment,
        .hljs-quote {
            color: #5c6370;
            font-style: italic
        }

        .hljs-doctag,
        .hljs-formula,
        .hljs-keyword {
            color: #c678dd
        }

        .hljs-deletion,
        .hljs-name,
        .hljs-section,
        .hljs-selector-tag,
        .hljs-subst {
            color: #e06c75
        }

        .hljs-literal {
            color: #56b6c2
        }

        .hljs-addition,
        .hljs-attribute,
        .hljs-meta .hljs-string,
        .hljs-regexp,
        .hljs-string {
            color: #98c379
        }

        .hljs-attr,
        .hljs-number,
        .hljs-selector-attr,
        .hljs-selector-class,
        .hljs-selector-pseudo,
        .hljs-template-variable,
        .hljs-type,
        .hljs-variable {
            color: #d19a66
        }

        .hljs-bullet,
        .hljs-link,
        .hljs-meta,
        .hljs-selector-id,
        .hljs-symbol,
        .hljs-title {
            color: #61aeee
        }

        .hljs-built_in,
        .hljs-class .hljs-title,
        .hljs-title.class_ {
            color: #e6c07b
        }

        .hljs-emphasis {
            font-style: italic
        }

        .hljs-strong {
            font-weight: 700
        }

        .hljs-link {
            text-decoration: underline
        }
    </style>

    <style>
        #frame-0 .hljs-ln-line[data-line-number='124'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-1 .hljs-ln-line[data-line-number='46'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-2 .hljs-ln-line[data-line-number='265'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-3 .hljs-ln-line[data-line-number='211'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-4 .hljs-ln-line[data-line-number='808'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-5 .hljs-ln-line[data-line-number='169'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-6 .hljs-ln-line[data-line-number='50'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-7 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-8 .hljs-ln-line[data-line-number='63'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-9 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-10 .hljs-ln-line[data-line-number='26'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-11 .hljs-ln-line[data-line-number='169'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-12 .hljs-ln-line[data-line-number='126'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-13 .hljs-ln-line[data-line-number='25'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-14 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-15 .hljs-ln-line[data-line-number='126'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-16 .hljs-ln-line[data-line-number='807'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-17 .hljs-ln-line[data-line-number='786'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-18 .hljs-ln-line[data-line-number='750'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-19 .hljs-ln-line[data-line-number='739'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-20 .hljs-ln-line[data-line-number='200'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-21 .hljs-ln-line[data-line-number='169'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-22 .hljs-ln-line[data-line-number='21'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-23 .hljs-ln-line[data-line-number='31'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-24 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-25 .hljs-ln-line[data-line-number='21'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-26 .hljs-ln-line[data-line-number='51'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-27 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-28 .hljs-ln-line[data-line-number='27'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-29 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-30 .hljs-ln-line[data-line-number='109'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-31 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-32 .hljs-ln-line[data-line-number='61'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-33 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-34 .hljs-ln-line[data-line-number='58'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-35 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-36 .hljs-ln-line[data-line-number='22'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-37 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-38 .hljs-ln-line[data-line-number='26'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-39 .hljs-ln-line[data-line-number='208'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-40 .hljs-ln-line[data-line-number='126'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-41 .hljs-ln-line[data-line-number='175'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-42 .hljs-ln-line[data-line-number='144'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-43 .hljs-ln-line[data-line-number='1219'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-44 .hljs-ln-line[data-line-number='20'] {
            background-color: rgba(242, 95, 95, 0.4);
        }

        #frame-45 .hljs-ln-line[data-line-number='139'] {
            background-color: rgba(242, 95, 95, 0.4);
        }
    </style>
</head>

<body class="bg-gray-200/80 font-sans antialiased dark:bg-gray-950/95">
    <div class="renderer container mx-auto lg:px-8">
        <header class="mt-3 px-5 sm:mt-10">
            <div class="py-3 dark:border-gray-900 sm:py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="rounded-full bg-red-500/20 p-4 dark:bg-red-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-6 w-6 fill-red-500 text-gray-50 dark:text-gray-950">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>

                        <span class="text-dark ml-3 text-2xl font-bold dark:text-white sm:text-3xl">
                    Internal Server Error
                </span>
                    </div>

                    <div class="flex items-center gap-3 sm:gap-6">
                        <script>
                            (function () {
        const darkStyles = document.querySelector('style[data-theme="dark"]')?.textContent
        const lightStyles = document.querySelector('style[data-theme="light"]')?.textContent

        const removeStyles = () => {
            document.querySelector('style[data-theme="dark"]')?.remove()
            document.querySelector('style[data-theme="light"]')?.remove()
        }

        removeStyles()

        setDarkClass = () => {
            removeStyles()

            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)

            isDark ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')

            if (isDark) {
                document.head.insertAdjacentHTML('beforeend', `<style data-theme="dark">${darkStyles}</style>`)
            } else {
                document.head.insertAdjacentHTML('beforeend', `<style data-theme="light">${lightStyles}</style>`)
            }
        }

        setDarkClass()

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setDarkClass)
    })();
                        </script>

                        <div class="relative" x-data="{
        menu: false,
        theme: localStorage.theme,
        darkMode() {
            this.theme = 'dark'
            localStorage.theme = 'dark'
            setDarkClass()
        },
        lightMode() {
            this.theme = 'light'
            localStorage.theme = 'light'
            setDarkClass()
        },
        systemMode() {
            this.theme = undefined
            localStorage.removeItem('theme')
            setDarkClass()
        },
    }" @click.outside="menu = false">
                            <button
        x-cloak
        class="block rounded p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
        :class="theme ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-600 hover:text-gray-500 focus:text-gray-500 dark:hover:text-gray-500 dark:focus:text-gray-500'"
        @click="menu = ! menu"
    >
        <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    class="block h-5 w-5 dark:hidden"
>
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
</svg>
        <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    class="hidden h-5 w-5 dark:block"
>
    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
</svg>
    </button>

                            <div x-show="menu"
                                class="absolute right-0 z-10 flex origin-top-right flex-col rounded-md bg-white shadow-xl ring-1 ring-gray-900/5 dark:bg-gray-800"
                                style="display: none" @click="menu = false">
                                <button
            class="flex items-center gap-3 px-4 py-2 hover:rounded-t-md hover:bg-gray-100 dark:hover:bg-gray-700"
            :class="theme === 'light' ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
            @click="lightMode()"
        >
            <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    class="h-5 w-5"
>
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
</svg>
            Light
        </button>
                                <button
            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
            :class="theme === 'dark' ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
            @click="darkMode()"
        >
            <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    class="h-5 w-5"
>
    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
</svg>
            Dark
        </button>
                                <button
            class="flex items-center gap-3 px-4 py-2 hover:rounded-b-md hover:bg-gray-100 dark:hover:bg-gray-700"
            :class="theme === undefined ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
            @click="systemMode()"
        >
            <svg
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
    class="h-5 w-5"
>
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
</svg>
            System
        </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-6 pb-12 pt-6">
            <div class="container mx-auto">
                <section
                    class="@container flex flex-col p-6 sm:p-12 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg default:col-span-full default:lg:col-span-6 default:row-span-1 dark:ring-1 dark:ring-gray-800 shadow-xl">
                    <div class="md:flex md:items-center md:justify-between md:gap-2">
                        <div class="min-w-0">
                            <div
                                class="inline-block rounded-full bg-red-500/20 px-3 py-2 max-w-full text-sm font-bold leading-5 text-red-500 truncate lg:text-base dark:bg-red-500/20">
                                <span class="hidden md:inline">
                    Error
                </span>
                                <span class="md:hidden">
                    Error
                </span>
                            </div>
                            <div
                                class="mt-4 text-lg font-semibold text-gray-900 break-words dark:text-white lg:text-2xl">
                                Class &quot;App\Http\Controllers\Api\V1\DB&quot; not found
                            </div>
                        </div>

                        <div class="hidden text-right shrink-0 md:block md:min-w-64 md:max-w-80">
                            <div>
                                <span class="inline-block rounded-full bg-gray-200 px-3 py-2 text-sm leading-5 text-gray-900 max-w-full truncate dark:bg-gray-800 dark:text-white">
                    POST k22cnt3_project4_minichat.test
                </span>
                            </div>
                            <div class="px-4">
                                <span class="text-sm text-gray-500 dark:text-gray-400">PHP 8.4.8 — Laravel 12.16.0</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    class="@container flex flex-col p-6 sm:p-12 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg default:col-span-full default:lg:col-span-6 default:row-span-1 dark:ring-1 dark:ring-gray-800 shadow-xl mt-6 overflow-x-auto">
                    <div x-data="{
            includeVendorFrames: false,
            index: 0,
        }">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3" x-clock>
                            <div class="hidden overflow-x-auto sm:col-span-1 lg:block">
                                <div
                                    class="h-[35.5rem] scrollbar-hidden trace text-sm text-gray-400 dark:text-gray-300">
                                    <div
                                        class="mb-2 inline-block rounded-full bg-red-500/20 px-3 py-2 dark:bg-red-500/20 sm:col-span-1">
                                        <button
                @click="includeVendorFrames = !includeVendorFrames"
                class="inline-flex items-center font-bold leading-5 text-red-500"
            >
                <span x-show="includeVendorFrames">Collapse</span>
                <span
                    x-cloak
                    x-show="!includeVendorFrames"
                    >Expand</span
                >
                <span class="ml-1">vendor frames</span>

                <div class="flex flex-col ml-1 -mt-2" x-cloak x-show="includeVendorFrames">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" style="margin-bottom: -8px;">
    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
</svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" style="margin-bottom: -8px;">
  <path fill-rule="evenodd" d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z" clip-rule="evenodd" />
</svg>
                </div>

                <div class="flex flex-col ml-1 -mt-2" x-cloak x-show="! includeVendorFrames">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" style="margin-bottom: -8px;">
  <path fill-rule="evenodd" d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z" clip-rule="evenodd" />
</svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" style="margin-bottom: -8px;">
    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
</svg>
                </div>
            </button>
                                    </div>

                                    <div class="mb-12 space-y-2">

                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 0"
                >
                    <div
                        x-bind:class="
                            index === 0
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\app\Http\Controllers\Api\V1\AuthController.php</span>
                                    <span class="font-mono text-xs">:124</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                editUser
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 1"
                >
                    <div
                        x-bind:class="
                            index === 1
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\ControllerDispatcher</span>
                                    <span class="font-mono text-xs">:46</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                dispatch
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 2"
                >
                    <div
                        x-bind:class="
                            index === 2
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Route</span>
                                    <span class="font-mono text-xs">:265</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                runController
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 3"
                >
                    <div
                        x-bind:class="
                            index === 3
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Route</span>
                                    <span class="font-mono text-xs">:211</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                run
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 4"
                >
                    <div
                        x-bind:class="
                            index === 4
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Router</span>
                                    <span class="font-mono text-xs">:808</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Illuminate\Routing\Router::runRouteWithinStack():807}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 5"
                >
                    <div
                        x-bind:class="
                            index === 5
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:169</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Illuminate\Pipeline\Pipeline::prepareDestination():167}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 6"
                >
                    <div
                        x-bind:class="
                            index === 6
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Middleware\SubstituteBindings</span>
                                    <span class="font-mono text-xs">:50</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 7"
                >
                    <div
                        x-bind:class="
                            index === 7
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 8"
                >
                    <div
                        x-bind:class="
                            index === 8
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Auth\Middleware\Authenticate</span>
                                    <span class="font-mono text-xs">:63</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 9"
                >
                    <div
                        x-bind:class="
                            index === 9
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 10"
                >
                    <div
                        x-bind:class="
                            index === 10
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful</span>
                                    <span class="font-mono text-xs">:26</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::handle():25}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 11"
                >
                    <div
                        x-bind:class="
                            index === 11
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:169</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Illuminate\Pipeline\Pipeline::prepareDestination():167}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 12"
                >
                    <div
                        x-bind:class="
                            index === 12
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:126</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                then
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 13"
                >
                    <div
                        x-bind:class="
                            index === 13
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful</span>
                                    <span class="font-mono text-xs">:25</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 14"
                >
                    <div
                        x-bind:class="
                            index === 14
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 15"
                >
                    <div
                        x-bind:class="
                            index === 15
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:126</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                then
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 16"
                >
                    <div
                        x-bind:class="
                            index === 16
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Router</span>
                                    <span class="font-mono text-xs">:807</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                runRouteWithinStack
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 17"
                >
                    <div
                        x-bind:class="
                            index === 17
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Router</span>
                                    <span class="font-mono text-xs">:786</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                runRoute
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 18"
                >
                    <div
                        x-bind:class="
                            index === 18
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Router</span>
                                    <span class="font-mono text-xs">:750</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                dispatchToRoute
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 19"
                >
                    <div
                        x-bind:class="
                            index === 19
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Routing\Router</span>
                                    <span class="font-mono text-xs">:739</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                dispatch
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 20"
                >
                    <div
                        x-bind:class="
                            index === 20
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Kernel</span>
                                    <span class="font-mono text-xs">:200</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Illuminate\Foundation\Http\Kernel::dispatchToRouter():197}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 21"
                >
                    <div
                        x-bind:class="
                            index === 21
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:169</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:Illuminate\Pipeline\Pipeline::prepareDestination():167}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 22"
                >
                    <div
                        x-bind:class="
                            index === 22
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\TransformsRequest</span>
                                    <span class="font-mono text-xs">:21</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 23"
                >
                    <div
                        x-bind:class="
                            index === 23
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull</span>
                                    <span class="font-mono text-xs">:31</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 24"
                >
                    <div
                        x-bind:class="
                            index === 24
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 25"
                >
                    <div
                        x-bind:class="
                            index === 25
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\TransformsRequest</span>
                                    <span class="font-mono text-xs">:21</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 26"
                >
                    <div
                        x-bind:class="
                            index === 26
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\TrimStrings</span>
                                    <span class="font-mono text-xs">:51</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 27"
                >
                    <div
                        x-bind:class="
                            index === 27
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 28"
                >
                    <div
                        x-bind:class="
                            index === 28
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Http\Middleware\ValidatePostSize</span>
                                    <span class="font-mono text-xs">:27</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 29"
                >
                    <div
                        x-bind:class="
                            index === 29
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 30"
                >
                    <div
                        x-bind:class="
                            index === 30
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance</span>
                                    <span class="font-mono text-xs">:109</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 31"
                >
                    <div
                        x-bind:class="
                            index === 31
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 32"
                >
                    <div
                        x-bind:class="
                            index === 32
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Http\Middleware\HandleCors</span>
                                    <span class="font-mono text-xs">:61</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 33"
                >
                    <div
                        x-bind:class="
                            index === 33
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 34"
                >
                    <div
                        x-bind:class="
                            index === 34
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Http\Middleware\TrustProxies</span>
                                    <span class="font-mono text-xs">:58</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 35"
                >
                    <div
                        x-bind:class="
                            index === 35
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 36"
                >
                    <div
                        x-bind:class="
                            index === 36
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks</span>
                                    <span class="font-mono text-xs">:22</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 37"
                >
                    <div
                        x-bind:class="
                            index === 37
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 38"
                >
                    <div
                        x-bind:class="
                            index === 38
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Http\Middleware\ValidatePathEncoding</span>
                                    <span class="font-mono text-xs">:26</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 39"
                >
                    <div
                        x-bind:class="
                            index === 39
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:208</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                {closure:{closure:Illuminate\Pipeline\Pipeline::carry():183}:184}
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 40"
                >
                    <div
                        x-bind:class="
                            index === 40
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Pipeline\Pipeline</span>
                                    <span class="font-mono text-xs">:126</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                then
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 41"
                >
                    <div
                        x-bind:class="
                            index === 41
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Kernel</span>
                                    <span class="font-mono text-xs">:175</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                sendRequestThroughRouter
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 42"
                >
                    <div
                        x-bind:class="
                            index === 42
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Http\Kernel</span>
                                    <span class="font-mono text-xs">:144</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handle
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 43"
                >
                    <div
                        x-bind:class="
                            index === 43
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">Illuminate\Foundation\Application</span>
                                    <span class="font-mono text-xs">:1219</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                handleRequest
                            </div>
                        </div>
                    </div>
                </button>


                                        <div x-show="! includeVendorFrames">
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="true"
                    @click="index = 44"
                >
                    <div
                        x-bind:class="
                            index === 44
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\public\index.php</span>
                                    <span class="font-mono text-xs">:20</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                require
                            </div>
                        </div>
                    </div>
                </button>

                                        <div x-show="! includeVendorFrames">
                                            <div class="text-gray-500">
                                                1 vendor
                                                frame collapsed
                                            </div>
                                        </div>

                                        <button
                    class="w-full text-left dark:border-gray-900"
                    x-show="includeVendorFrames"
                    @click="index = 45"
                >
                    <div
                        x-bind:class="
                            index === 45
                                ? 'rounded-r-md bg-gray-100 dark:bg-gray-800 border-l dark:border dark:border-gray-700 border-l-red-500 dark:border-l-red-500'
                                : 'hover:bg-gray-100/75 dark:hover:bg-gray-800/75'
                        "
                    >
                        <div class="scrollbar-hidden overflow-x-auto border-l-2 border-transparent p-2">
                            <div class="nowrap text-gray-900 dark:text-gray-300">
                                <span class="inline-flex items-baseline">
                                    <span class="text-gray-900 dark:text-gray-300">C:\Program Files\Herd\resources\app.asar.unpacked\resources\valet\server.php</span>
                                    <span class="font-mono text-xs">:139</span>
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">

                            </div>
                        </div>
                    </div>
                </button>

                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 0">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\app\Http\Controllers\Api\V1\AuthController.php</span>

                                            <span class="font-mono text-xs">:124</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-0"
                    class="language-php highlightable-code  default-highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="124"
                    data-ln-start-from="119"
                >            }
            // Lưu avatar mới
            $path = $request-&gt;file(&#039;avatar&#039;)-&gt;store(&#039;avatars&#039;, &#039;public&#039;);
            $data[&#039;avatar&#039;] = $path;
        }
        DB::beginTransaction();
        try {
            // Cập nhật người dùng
            $user-&gt;update($data);
            DB::commit();

            // Trả về phản hồi
            return $this-&gt;success([
                &#039;id&#039; =&gt; $user-&gt;id,
                &#039;name&#039; =&gt; $user-&gt;name,
                &#039;password&#039; =&gt; $user-&gt;password,
                &#039;email&#039; =&gt; $user-&gt;email,
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 1">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\ControllerDispatcher.php</span>

                                            <span class="font-mono text-xs">:46</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-1"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="46"
                    data-ln-start-from="41"
                >
        if (method_exists($controller, &#039;callAction&#039;)) {
            return $controller-&gt;callAction($method, $parameters);
        }

        return $controller-&gt;{$method}(...array_values($parameters));
    }

    /**
     * Resolve the parameters for the controller.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  mixed  $controller
     * @param  string  $method
     * @return array
     */
    protected function resolveParameters(Route $route, $controller, $method)
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 2">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Route.php</span>

                                            <span class="font-mono text-xs">:265</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-2"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="265"
                    data-ln-start-from="260"
                >     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function runController()
    {
        return $this-&gt;controllerDispatcher()-&gt;dispatch(
            $this, $this-&gt;getController(), $this-&gt;getControllerMethod()
        );
    }

    /**
     * Get the controller instance for the route.
     *
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 3">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Route.php</span>

                                            <span class="font-mono text-xs">:211</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-3"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="211"
                    data-ln-start-from="206"
                >    {
        $this-&gt;container = $this-&gt;container ?: new Container;

        try {
            if ($this-&gt;isControllerAction()) {
                return $this-&gt;runController();
            }

            return $this-&gt;runCallable();
        } catch (HttpResponseException $e) {
            return $e-&gt;getResponse();
        }
    }

    /**
     * Checks whether the route&#039;s action is a controller.
     *
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 4">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Router.php</span>

                                            <span class="font-mono text-xs">:808</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-4"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="808"
                    data-ln-start-from="803"
                >
        return (new Pipeline($this-&gt;container))
            -&gt;send($request)
            -&gt;through($middleware)
            -&gt;then(fn ($request) =&gt; $this-&gt;prepareResponse(
                $request, $route-&gt;run()
            ));
    }

    /**
     * Gather the middleware for the given route with resolved class names.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    public function gatherRouteMiddleware(Route $route)
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 5">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:169</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-5"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="169"
                    data-ln-start-from="164"
                >     */
    protected function prepareDestination(Closure $destination)
    {
        return function ($passable) use ($destination) {
            try {
                return $destination($passable);
            } catch (Throwable $e) {
                return $this-&gt;handleException($passable, $e);
            }
        };
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 6">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Middleware\SubstituteBindings.php</span>

                                            <span class="font-mono text-xs">:50</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-6"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="50"
                    data-ln-start-from="45"
                >            }

            throw $exception;
        }

        return $next($request);
    }
}
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 7">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-7"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 8">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Auth\Middleware\Authenticate.php</span>

                                            <span class="font-mono text-xs">:63</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-8"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="63"
                    data-ln-start-from="58"
                >     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this-&gt;authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 9">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-9"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 10">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\sanctum\src\Http\Middleware\EnsureFrontendRequestsAreStateful.php</span>

                                            <span class="font-mono text-xs">:26</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-10"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="26"
                    data-ln-start-from="21"
                >        $this-&gt;configureSecureCookieSessions();

        return (new Pipeline(app()))-&gt;send($request)-&gt;through(
            static::fromFrontend($request) ? $this-&gt;frontendMiddleware() : []
        )-&gt;then(function ($request) use ($next) {
            return $next($request);
        });
    }

    /**
     * Configure secure cookie sessions.
     *
     * @return void
     */
    protected function configureSecureCookieSessions()
    {
        config([
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 11">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:169</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-11"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="169"
                    data-ln-start-from="164"
                >     */
    protected function prepareDestination(Closure $destination)
    {
        return function ($passable) use ($destination) {
            try {
                return $destination($passable);
            } catch (Throwable $e) {
                return $this-&gt;handleException($passable, $e);
            }
        };
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 12">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:126</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-12"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="126"
                    data-ln-start-from="121"
                >        $pipeline = array_reduce(
            array_reverse($this-&gt;pipes()), $this-&gt;carry(), $this-&gt;prepareDestination($destination)
        );

        try {
            return $pipeline($this-&gt;passable);
        } finally {
            if ($this-&gt;finally) {
                ($this-&gt;finally)($this-&gt;passable);
            }
        }
    }

    /**
     * Run the pipeline and return the result.
     *
     * @return mixed
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 13">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\sanctum\src\Http\Middleware\EnsureFrontendRequestsAreStateful.php</span>

                                            <span class="font-mono text-xs">:25</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-13"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="25"
                    data-ln-start-from="20"
                >    {
        $this-&gt;configureSecureCookieSessions();

        return (new Pipeline(app()))-&gt;send($request)-&gt;through(
            static::fromFrontend($request) ? $this-&gt;frontendMiddleware() : []
        )-&gt;then(function ($request) use ($next) {
            return $next($request);
        });
    }

    /**
     * Configure secure cookie sessions.
     *
     * @return void
     */
    protected function configureSecureCookieSessions()
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 14">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-14"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 15">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:126</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-15"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="126"
                    data-ln-start-from="121"
                >        $pipeline = array_reduce(
            array_reverse($this-&gt;pipes()), $this-&gt;carry(), $this-&gt;prepareDestination($destination)
        );

        try {
            return $pipeline($this-&gt;passable);
        } finally {
            if ($this-&gt;finally) {
                ($this-&gt;finally)($this-&gt;passable);
            }
        }
    }

    /**
     * Run the pipeline and return the result.
     *
     * @return mixed
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 16">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Router.php</span>

                                            <span class="font-mono text-xs">:807</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-16"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="807"
                    data-ln-start-from="802"
                >        $middleware = $shouldSkipMiddleware ? [] : $this-&gt;gatherRouteMiddleware($route);

        return (new Pipeline($this-&gt;container))
            -&gt;send($request)
            -&gt;through($middleware)
            -&gt;then(fn ($request) =&gt; $this-&gt;prepareResponse(
                $request, $route-&gt;run()
            ));
    }

    /**
     * Gather the middleware for the given route with resolved class names.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    public function gatherRouteMiddleware(Route $route)
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 17">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Router.php</span>

                                            <span class="font-mono text-xs">:786</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-17"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="786"
                    data-ln-start-from="781"
                >        $request-&gt;setRouteResolver(fn () =&gt; $route);

        $this-&gt;events-&gt;dispatch(new RouteMatched($route, $request));

        return $this-&gt;prepareResponse($request,
            $this-&gt;runRouteWithinStack($route, $request)
        );
    }

    /**
     * Run the given route within a Stack &quot;onion&quot; instance.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function runRouteWithinStack(Route $route, Request $request)
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 18">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Router.php</span>

                                            <span class="font-mono text-xs">:750</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-18"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="750"
                    data-ln-start-from="745"
                >     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dispatchToRoute(Request $request)
    {
        return $this-&gt;runRoute($request, $this-&gt;findRoute($request));
    }

    /**
     * Find the route matching a given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Route
     */
    protected function findRoute($request)
    {
        $this-&gt;events-&gt;dispatch(new Routing($request));
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 19">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Routing\Router.php</span>

                                            <span class="font-mono text-xs">:739</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-19"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="739"
                    data-ln-start-from="734"
                >     */
    public function dispatch(Request $request)
    {
        $this-&gt;currentRequest = $request;

        return $this-&gt;dispatchToRoute($request);
    }

    /**
     * Dispatch the request to a route and return the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dispatchToRoute(Request $request)
    {
        return $this-&gt;runRoute($request, $this-&gt;findRoute($request));
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 20">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php</span>

                                            <span class="font-mono text-xs">:200</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-20"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="200"
                    data-ln-start-from="195"
                >    protected function dispatchToRouter()
    {
        return function ($request) {
            $this-&gt;app-&gt;instance(&#039;request&#039;, $request);

            return $this-&gt;router-&gt;dispatch($request);
        };
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 21">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:169</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-21"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="169"
                    data-ln-start-from="164"
                >     */
    protected function prepareDestination(Closure $destination)
    {
        return function ($passable) use ($destination) {
            try {
                return $destination($passable);
            } catch (Throwable $e) {
                return $this-&gt;handleException($passable, $e);
            }
        };
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 22">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php</span>

                                            <span class="font-mono text-xs">:21</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-22"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="21"
                    data-ln-start-from="16"
                >     */
    public function handle($request, Closure $next)
    {
        $this-&gt;clean($request);

        return $next($request);
    }

    /**
     * Clean the request&#039;s data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clean($request)
    {
        $this-&gt;cleanParameterBag($request-&gt;query);
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 23">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull.php</span>

                                            <span class="font-mono text-xs">:31</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-23"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="31"
                    data-ln-start-from="26"
                >            if ($callback($request)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 24">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-24"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 25">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php</span>

                                            <span class="font-mono text-xs">:21</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-25"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="21"
                    data-ln-start-from="16"
                >     */
    public function handle($request, Closure $next)
    {
        $this-&gt;clean($request);

        return $next($request);
    }

    /**
     * Clean the request&#039;s data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clean($request)
    {
        $this-&gt;cleanParameterBag($request-&gt;query);
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 26">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TrimStrings.php</span>

                                            <span class="font-mono text-xs">:51</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-26"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="51"
                    data-ln-start-from="46"
                >            if ($callback($request)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 27">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-27"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 28">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePostSize.php</span>

                                            <span class="font-mono text-xs">:27</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-28"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="27"
                    data-ln-start-from="22"
                >
        if ($max &gt; 0 &amp;&amp; $request-&gt;server(&#039;CONTENT_LENGTH&#039;) &gt; $max) {
            throw new PostTooLargeException(&#039;The POST data is too large.&#039;);
        }

        return $next($request);
    }

    /**
     * Determine the server &#039;post_max_size&#039; as bytes.
     *
     * @return int
     */
    protected function getPostMaxSize()
    {
        if (is_numeric($postMaxSize = ini_get(&#039;post_max_size&#039;))) {
            return (int) $postMaxSize;
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 29">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-29"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 30">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance.php</span>

                                            <span class="font-mono text-xs">:109</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-30"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="109"
                    data-ln-start-from="104"
                >                null,
                $this-&gt;getHeaders($data)
            );
        }

        return $next($request);
    }

    /**
     * Determine if the incoming request has a maintenance mode bypass cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $data
     * @return bool
     */
    protected function hasValidBypassCookie($request, array $data)
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 31">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-31"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 32">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Http\Middleware\HandleCors.php</span>

                                            <span class="font-mono text-xs">:61</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-32"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="61"
                    data-ln-start-from="56"
                >            $this-&gt;cors-&gt;varyHeader($response, &#039;Access-Control-Request-Method&#039;);

            return $response;
        }

        $response = $next($request);

        if ($request-&gt;getMethod() === &#039;OPTIONS&#039;) {
            $this-&gt;cors-&gt;varyHeader($response, &#039;Access-Control-Request-Method&#039;);
        }

        return $this-&gt;cors-&gt;addActualRequestHeaders($response, $request);
    }

    /**
     * Get the path from the configuration to determine if the CORS service should run.
     *
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 33">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-33"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 34">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Http\Middleware\TrustProxies.php</span>

                                            <span class="font-mono text-xs">:58</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-34"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="58"
                    data-ln-start-from="53"
                >    {
        $request::setTrustedProxies([], $this-&gt;getTrustedHeaderNames());

        $this-&gt;setTrustedProxyIpAddresses($request);

        return $next($request);
    }

    /**
     * Sets the trusted proxies on the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function setTrustedProxyIpAddresses(Request $request)
    {
        $trustedIps = $this-&gt;proxies() ?: config(&#039;trustedproxy.proxies&#039;);
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 35">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-35"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 36">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks.php</span>

                                            <span class="font-mono text-xs">:22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-36"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="22"
                    data-ln-start-from="17"
                >     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Invoke the deferred callbacks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 37">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-37"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 38">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePathEncoding.php</span>

                                            <span class="font-mono text-xs">:26</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-38"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="26"
                    data-ln-start-from="21"
                >
        if (! mb_check_encoding($decodedPath, &#039;UTF-8&#039;)) {
            throw new MalformedUrlException;
        }

        return $next($request);
    }
}
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 39">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:208</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-39"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="208"
                    data-ln-start-from="203"
                >                        // since the object we&#039;re given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $carry = method_exists($pipe, $this-&gt;method)
                        ? $pipe-&gt;{$this-&gt;method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this-&gt;handleCarry($carry);
                } catch (Throwable $e) {
                    return $this-&gt;handleException($passable, $e);
                }
            };
        };
    }

    /**
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 40">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php</span>

                                            <span class="font-mono text-xs">:126</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-40"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="126"
                    data-ln-start-from="121"
                >        $pipeline = array_reduce(
            array_reverse($this-&gt;pipes()), $this-&gt;carry(), $this-&gt;prepareDestination($destination)
        );

        try {
            return $pipeline($this-&gt;passable);
        } finally {
            if ($this-&gt;finally) {
                ($this-&gt;finally)($this-&gt;passable);
            }
        }
    }

    /**
     * Run the pipeline and return the result.
     *
     * @return mixed
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 41">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php</span>

                                            <span class="font-mono text-xs">:175</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-41"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="175"
                    data-ln-start-from="170"
                >        $this-&gt;bootstrap();

        return (new Pipeline($this-&gt;app))
            -&gt;send($request)
            -&gt;through($this-&gt;app-&gt;shouldSkipMiddleware() ? [] : $this-&gt;middleware)
            -&gt;then($this-&gt;dispatchToRouter());
    }

    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (! $this-&gt;app-&gt;hasBeenBootstrapped()) {
            $this-&gt;app-&gt;bootstrapWith($this-&gt;bootstrappers());
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 42">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php</span>

                                            <span class="font-mono text-xs">:144</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-42"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="144"
                    data-ln-start-from="139"
                >        $this-&gt;requestStartedAt = Carbon::now();

        try {
            $request-&gt;enableHttpMethodParameterOverride();

            $response = $this-&gt;sendRequestThroughRouter($request);
        } catch (Throwable $e) {
            $this-&gt;reportException($e);

            $response = $this-&gt;renderException($request, $e);
        }

        $this-&gt;app[&#039;events&#039;]-&gt;dispatch(
            new RequestHandled($request, $response)
        );

        return $response;
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 43">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\vendor\laravel\framework\src\Illuminate\Foundation\Application.php</span>

                                            <span class="font-mono text-xs">:1219</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-43"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="1219"
                    data-ln-start-from="1214"
                >     */
    public function handleRequest(Request $request)
    {
        $kernel = $this-&gt;make(HttpKernelContract::class);

        $response = $kernel-&gt;handle($request)-&gt;send();

        $kernel-&gt;terminate($request, $response);
    }

    /**
     * Handle the incoming Artisan command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @return int
     */
    public function handleCommand(InputInterface $input)
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 44">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Users\lasng\Herd\k22cnt3_project4_minichat\public\index.php</span>

                                            <span class="font-mono text-xs">:20</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-44"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="20"
                    data-ln-start-from="15"
                >
// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.&#039;/../bootstrap/app.php&#039;;

$app-&gt;handleRequest(Request::capture());
</code></template></pre>
                                </div>
                            </div>
                            <div class="sm:col-span-2" x-show="index === 45">
                                <div class="mb-3">
                                    <div class="text-md text-gray-500 dark:text-gray-400">
                                        <div class="mb-2">

                                            <span class="wrap text-gray-900 dark:text-gray-300">C:\Program Files\Herd\resources\app.asar.unpacked\resources\valet\server.php</span>

                                            <span class="font-mono text-xs">:139</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 text-sm text-gray-500 dark:text-gray-400">
                                    <pre class="h-[32.5rem] rounded-md dark:bg-gray-800 border dark:border-gray-700"><template x-if="true"><code
                    style="display: none;"
                    id="frame-45"
                    class="language-php highlightable-code  scrollbar-hidden overflow-y-hidden"
                    data-line-number="139"
                    data-ln-start-from="134"
                >    } catch (\Throwable $e) {}
});

chdir(dirname($frontControllerPath));

require $frontControllerPath;
</code></template></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section
                    class="@container flex flex-col p-6 sm:p-12 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg default:col-span-full default:lg:col-span-6 default:row-span-1 dark:ring-1 dark:ring-gray-800 shadow-xl mt-6 overflow-x-auto">
                    <div>
                        <span class="text-xl font-bold lg:text-2xl">Request</span>
                    </div>

                    <div class="mt-2">
                        <span>POST</span>
                        <span class="text-gray-500">/api/v1/user</span>
                    </div>

                    <div class="mt-4">
                        <span class="font-semibold text-gray-900 dark:text-white">Headers</span>
                    </div>

                    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
                        <div class="flex items-center gap-2  dark:border-gray-800">
                            <span
                    data-tippy-content="content-length"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    content-length
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">31432</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="content-type"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    content-type
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">multipart/form-data; boundary=--------------------------191277595395993617126213</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="connection"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    connection
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">keep-alive</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="accept-encoding"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    accept-encoding
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">gzip, deflate, br</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="host"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    host
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">k22cnt3_project4_minichat.test</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="postman-token"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    postman-token
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">c391afd1-ddb0-4cfd-bbae-379c2467bee0</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="accept"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    accept
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">*/*</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="user-agent"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    user-agent
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">PostmanRuntime/7.44.1</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="authorization"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                >
                    authorization
                </span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">Bearer 55|QWbw3h31cTOfcFutj5eqcoT5fXgLcVQrfP9hBsO33d4c6942</code></pre>
                </span>
                        </div>
                    </dl>

                    <div class="mt-4">
                        <span class="font-semibold text-gray-900 dark:text-white">Body</span>
                    </div>

                    <div class="mt-1 rounded border dark:border-gray-800">
                        <div class="flex items-center">
                            <span
                class="min-w-0 flex-grow"
                style="-webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem))"
            >
                <pre class="scrollbar-hidden mx-5 my-3 overflow-y-hidden text-xs lg:text-sm"><code class="overflow-y-hidden scrollbar-hidden overflow-x-scroll scrollbar-hidden-x">{
    &quot;avatar&quot;: {}
}</code></pre>
            </span>
                        </div>
                    </div>
                </section>

                <section
                    class="@container flex flex-col p-6 sm:p-12 bg-white dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 rounded-lg default:col-span-full default:lg:col-span-6 default:row-span-1 dark:ring-1 dark:ring-gray-800 shadow-xl mt-6 overflow-x-auto">
                    <div>
                        <span class="text-xl font-bold lg:text-2xl">Application</span>
                    </div>

                    <div class="mt-4">
                        <span class="font-semibold text-gray-900 dark:text-white"> Routing </span>
                    </div>

                    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
                        <div class="flex items-center gap-2  dark:border-gray-800">
                            <span
                    data-tippy-content="controller"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                    >controller</span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">App\Http\Controllers\Api\V1\AuthController@editUser</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="route name"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                    >route name</span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">v1.editUser</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <span
                    data-tippy-content="middleware"
                    class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                    >middleware</span>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">api, auth:sanctum</code></pre>
                </span>
                        </div>
                    </dl>


                    <div class="mt-4">
                        <span class="font-semibold text-gray-900 dark:text-white"> Database Queries </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                    </span>
                    </div>

                    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
                        <div class="flex items-center gap-2  dark:border-gray-800">
                            <div
                                class="lg:text-md w-[8rem] flex-none truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]">
                                <span>mysql</span>
                                <span class="hidden text-xs text-gray-500 lg:inline-block">(9.97 ms)</span>
                            </div>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">select * from `personal_access_tokens` where `personal_access_tokens`.`id` = &#039;55&#039; limit 1</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <div
                                class="lg:text-md w-[8rem] flex-none truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]">
                                <span>mysql</span>
                                <span class="hidden text-xs text-gray-500 lg:inline-block">(1.19 ms)</span>
                            </div>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">select * from `users` where `users`.`id` = 9 limit 1</code></pre>
                </span>
                        </div>
                        <div class="flex items-center gap-2 border-t dark:border-gray-800">
                            <div
                                class="lg:text-md w-[8rem] flex-none truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]">
                                <span>mysql</span>
                                <span class="hidden text-xs text-gray-500 lg:inline-block">(4.14 ms)</span>
                            </div>
                            <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x">update `personal_access_tokens` set `last_used_at` = &#039;2025-06-23 01:24:34&#039;, `personal_access_tokens`.`updated_at` = &#039;2025-06-23 01:24:34&#039; where `id` = 55</code></pre>
                </span>
                        </div>
                    </dl>
                </section>
            </div>
        </main>
    </div>

    <script>
        !function(r,o){"use strict";var e,i="hljs-ln",l="hljs-ln-line",h="hljs-ln-code",s="hljs-ln-numbers",c="hljs-ln-n",m="data-line-number",a=/\r\n|\r|\n/g;function u(e){for(var n=e.toString(),t=e.anchorNode;"TD"!==t.nodeName;)t=t.parentNode;for(var r=e.focusNode;"TD"!==r.nodeName;)r=r.parentNode;var o=parseInt(t.dataset.lineNumber),a=parseInt(r.dataset.lineNumber);if(o==a)return n;var i,l=t.textContent,s=r.textContent;for(a<o&&(i=o,o=a,a=i,i=l,l=s,s=i);0!==n.indexOf(l);)l=l.slice(1);for(;-1===n.lastIndexOf(s);)s=s.slice(0,-1);for(var c=l,u=function(e){for(var n=e;"TABLE"!==n.nodeName;)n=n.parentNode;return n}(t),d=o+1;d<a;++d){var f=p('.{0}[{1}="{2}"]',[h,m,d]);c+="\n"+u.querySelector(f).textContent}return c+="\n"+s}function n(e){try{var n=o.querySelectorAll("code.hljs,code.nohighlight");for(var t in n)n.hasOwnProperty(t)&&(n[t].classList.contains("nohljsln")||d(n[t],e))}catch(e){r.console.error("LineNumbers error: ",e)}}function d(e,n){"object"==typeof e&&r.setTimeout(function(){e.innerHTML=f(e,n)},0)}function f(e,n){var t,r,o=(t=e,{singleLine:function(e){return!!e.singleLine&&e.singleLine}(r=(r=n)||{}),startFrom:function(e,n){var t=1;isFinite(n.startFrom)&&(t=n.startFrom);var r=function(e,n){return e.hasAttribute(n)?e.getAttribute(n):null}(e,"data-ln-start-from");return null!==r&&(t=function(e,n){if(!e)return n;var t=Number(e);return isFinite(t)?t:n}(r,1)),t}(t,r)});return function e(n){var t=n.childNodes;for(var r in t){var o;t.hasOwnProperty(r)&&(o=t[r],0<(o.textContent.trim().match(a)||[]).length&&(0<o.childNodes.length?e(o):v(o.parentNode)))}}(e),function(e,n){var t=g(e);""===t[t.length-1].trim()&&t.pop();if(1<t.length||n.singleLine){for(var r="",o=0,a=t.length;o<a;o++)r+=p('<tr><td class="{0} {1}" {3}="{5}"><div class="{2}" {3}="{5}"></div></td><td class="{0} {4}" {3}="{5}">{6}</td></tr>',[l,s,c,m,h,o+n.startFrom,0<t[o].length?t[o]:" "]);return p('<table class="{0}">{1}</table>',[i,r])}return e}(e.innerHTML,o)}function v(e){var n=e.className;if(/hljs-/.test(n)){for(var t=g(e.innerHTML),r=0,o="";r<t.length;r++){o+=p('<span class="{0}">{1}</span>\n',[n,0<t[r].length?t[r]:" "])}e.innerHTML=o.trim()}}function g(e){return 0===e.length?[]:e.split(a)}function p(e,t){return e.replace(/\{(\d+)\}/g,function(e,n){return void 0!==t[n]?t[n]:e})}r.hljs?(r.hljs.initLineNumbersOnLoad=function(e){"interactive"===o.readyState||"complete"===o.readyState?n(e):r.addEventListener("DOMContentLoaded",function(){n(e)})},r.hljs.lineNumbersBlock=d,r.hljs.lineNumbersValue=function(e,n){if("string"!=typeof e)return;var t=document.createElement("code");return t.innerHTML=e,f(t,n)},(e=o.createElement("style")).type="text/css",e.innerHTML=p(".{0}{border-collapse:collapse}.{0} td{padding:0}.{1}:before{content:attr({2})}",[i,c,m]),o.getElementsByTagName("head")[0].appendChild(e)):r.console.error("highlight.js not detected!"),document.addEventListener("copy",function(e){var n,t=window.getSelection();!function(e){for(var n=e;n;){if(n.className&&-1!==n.className.indexOf("hljs-ln-code"))return 1;n=n.parentNode}}(t.anchorNode)||(n=-1!==window.navigator.userAgent.indexOf("Edge")?u(t):t.toString(),e.clipboardData.setData("text/plain",n),e.preventDefault())})}(window,document);

        hljs.initLineNumbersOnLoad()

        window.addEventListener('load', function() {
            document.querySelectorAll('.renderer').forEach(function(element, index) {
                if (index > 0) {
                    element.remove();
                }
            });

            document.querySelector('.default-highlightable-code').style.display = 'block';

            document.querySelectorAll('.highlightable-code').forEach(function(element) {
                element.style.display = 'block';
            })
        });
    </script>
</body>

</html>
