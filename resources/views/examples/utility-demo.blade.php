@extends('layouts.dashboard')

@section('title', 'Utility Classes Demo')

@section('content')
<div class="u-container">
    <div class="u-mb-8">
        <h1 class="u-text-3xl u-font-bold u-text-gray-900 u-mb-2">Utility Classes Demo</h1>
        <p class="u-text-gray-600">This page demonstrates the utility classes available in the KMS KKN application.</p>
    </div>

    <!-- Layout Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Layout Examples</h2>
        
        <!-- Flexbox Demo -->
        <div class="u-card u-mb-6">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Flexbox Layout</h3>
            </div>
            <div class="u-card-body">
                <div class="u-flex u-justify-between u-items-center u-p-4 u-bg-gray-50 u-rounded-lg">
                    <div class="u-text-left">
                        <h4 class="u-font-semibold u-text-gray-900">Left Content</h4>
                        <p class="u-text-sm u-text-gray-600">This content is aligned to the left</p>
                    </div>
                    <div class="u-text-right">
                        <h4 class="u-font-semibold u-text-gray-900">Right Content</h4>
                        <p class="u-text-sm u-text-gray-600">This content is aligned to the right</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Demo -->
        <div class="u-card u-mb-6">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Grid Layout</h3>
            </div>
            <div class="u-card-body">
                <div class="u-grid u-grid-cols-1 u-md:grid-cols-2 u-lg:grid-cols-3 u-gap-4">
                    <div class="u-card u-bg-primary u-text-white">
                        <div class="u-card-body u-text-center">
                            <h4 class="u-font-semibold">Card 1</h4>
                            <p class="u-text-sm">Primary background</p>
                        </div>
                    </div>
                    <div class="u-card u-bg-success u-text-white">
                        <div class="u-card-body u-text-center">
                            <h4 class="u-font-semibold">Card 2</h4>
                            <p class="u-text-sm">Success background</p>
                        </div>
                    </div>
                    <div class="u-card u-bg-warning u-text-white">
                        <div class="u-card-body u-text-center">
                            <h4 class="u-font-semibold">Card 3</h4>
                            <p class="u-text-sm">Warning background</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Typography Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Typography Examples</h2>
        
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Text Sizes and Weights</h3>
            </div>
            <div class="u-card-body u-space-y-4">
                <div>
                    <h1 class="u-text-5xl u-font-bold u-text-gray-900">Heading 1 (5xl)</h1>
                    <h2 class="u-text-4xl u-font-bold u-text-gray-800">Heading 2 (4xl)</h2>
                    <h3 class="u-text-3xl u-font-semibold u-text-gray-800">Heading 3 (3xl)</h3>
                    <h4 class="u-text-2xl u-font-semibold u-text-gray-700">Heading 4 (2xl)</h4>
                    <h5 class="u-text-xl u-font-medium u-text-gray-700">Heading 5 (xl)</h5>
                    <h6 class="u-text-lg u-font-medium u-text-gray-600">Heading 6 (lg)</h6>
                </div>
                
                <div class="u-border-t u-pt-4">
                    <p class="u-text-base u-text-gray-700">Base text size (16px)</p>
                    <p class="u-text-sm u-text-gray-600">Small text size (14px)</p>
                    <p class="u-text-xs u-text-gray-500">Extra small text (12px)</p>
                </div>
                
                <div class="u-border-t u-pt-4">
                    <p class="u-font-light">Light weight text</p>
                    <p class="u-font-normal">Normal weight text</p>
                    <p class="u-font-medium">Medium weight text</p>
                    <p class="u-font-semibold">Semibold weight text</p>
                    <p class="u-font-bold">Bold weight text</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Color Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Color Examples</h2>
        
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Text Colors</h3>
            </div>
            <div class="u-card-body">
                <div class="u-grid u-grid-cols-2 u-md:grid-cols-4 u-gap-4">
                    <div class="u-text-center">
                        <p class="u-text-primary u-font-semibold">Primary</p>
                        <p class="u-text-sm u-text-gray-500">Blue accent</p>
                    </div>
                    <div class="u-text-center">
                        <p class="u-text-success u-font-semibold">Success</p>
                        <p class="u-text-sm u-text-gray-500">Green accent</p>
                    </div>
                    <div class="u-text-center">
                        <p class="u-text-warning u-font-semibold">Warning</p>
                        <p class="u-text-sm u-text-gray-500">Orange accent</p>
                    </div>
                    <div class="u-text-center">
                        <p class="u-text-danger u-font-semibold">Danger</p>
                        <p class="u-text-sm u-text-gray-500">Red accent</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Component Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Component Examples</h2>
        
        <!-- Buttons -->
        <div class="u-card u-mb-6">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Buttons</h3>
            </div>
            <div class="u-card-body">
                <div class="u-flex u-flex-wrap u-gap-3">
                    <button class="u-btn u-btn-primary">Primary Button</button>
                    <button class="u-btn u-btn-secondary">Secondary Button</button>
                    <button class="u-btn u-btn-success">Success Button</button>
                    <button class="u-btn u-btn-danger">Danger Button</button>
                </div>
                
                <div class="u-flex u-flex-wrap u-gap-3 u-mt-4">
                    <button class="u-btn u-btn-primary u-btn-sm">Small</button>
                    <button class="u-btn u-btn-primary">Normal</button>
                    <button class="u-btn u-btn-primary u-btn-lg">Large</button>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="u-card u-mb-6">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Alerts</h3>
            </div>
            <div class="u-card-body u-space-y-4">
                <div class="u-alert u-alert-success">
                    <div class="u-flex u-items-center u-gap-2">
                        <span>✅</span>
                        <span>This is a success alert with an icon.</span>
                    </div>
                </div>
                
                <div class="u-alert u-alert-error">
                    <div class="u-flex u-items-center u-gap-2">
                        <span>❌</span>
                        <span>This is an error alert with an icon.</span>
                    </div>
                </div>
                
                <div class="u-alert u-alert-warning">
                    <div class="u-flex u-items-center u-gap-2">
                        <span>⚠️</span>
                        <span>This is a warning alert with an icon.</span>
                    </div>
                </div>
                
                <div class="u-alert u-alert-info">
                    <div class="u-flex u-items-center u-gap-2">
                        <span>ℹ️</span>
                        <span>This is an info alert with an icon.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Badges -->
        <div class="u-card u-mb-6">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Badges</h3>
            </div>
            <div class="u-card-body">
                <div class="u-flex u-flex-wrap u-gap-3">
                    <span class="u-badge">Default</span>
                    <span class="u-badge u-badge-primary">Primary</span>
                    <span class="u-badge u-badge-success">Success</span>
                    <span class="u-badge u-badge-warning">Warning</span>
                    <span class="u-badge u-badge-danger">Danger</span>
                </div>
            </div>
        </div>

        <!-- Form Controls -->
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Form Controls</h3>
            </div>
            <div class="u-card-body u-space-y-4">
                <div>
                    <label class="u-block u-text-sm u-font-medium u-text-gray-700 u-mb-2">
                        Text Input
                    </label>
                    <input type="text" class="u-form-control" placeholder="Enter your text here">
                </div>
                
                <div>
                    <label class="u-block u-text-sm u-font-medium u-text-gray-700 u-mb-2">
                        Textarea
                    </label>
                    <textarea class="u-form-control" rows="3" placeholder="Enter your message here"></textarea>
                </div>
                
                <div>
                    <label class="u-block u-text-sm u-font-medium u-text-gray-700 u-mb-2">
                        Select
                    </label>
                    <select class="u-form-control">
                        <option>Choose an option</option>
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Interactive Examples</h2>
        
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Hover and Focus Effects</h3>
            </div>
            <div class="u-card-body">
                <div class="u-grid u-grid-cols-1 u-md:grid-cols-2 u-gap-6">
                    <div>
                        <h4 class="u-font-semibold u-mb-3">Hover Effects</h4>
                        <div class="u-space-y-3">
                            <button class="u-btn u-btn-primary u-hover:shadow-lg u-transition-all">
                                Hover for shadow
                            </button>
                            <div class="u-card u-hover:shadow-xl u-hover:scale-105 u-transition-all u-cursor-pointer">
                                <div class="u-card-body u-text-center">
                                    <p>Hover card for effects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="u-font-semibold u-mb-3">Focus Effects</h4>
                        <div class="u-space-y-3">
                            <input type="text" class="u-form-control u-focus:ring u-focus:outline-none" placeholder="Focus me">
                            <button class="u-btn u-btn-secondary u-focus:ring-2 u-focus:outline-none">
                                Focus button
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Responsive Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Responsive Examples</h2>
        
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Responsive Grid</h3>
            </div>
            <div class="u-card-body">
                <div class="u-grid u-grid-cols-1 u-sm:grid-cols-2 u-md:grid-cols-3 u-lg:grid-cols-4 u-gap-4">
                    <div class="u-card u-bg-gray-100">
                        <div class="u-card-body u-text-center">
                            <p class="u-font-semibold">1 Column</p>
                            <p class="u-text-xs u-text-gray-600">Mobile</p>
                        </div>
                    </div>
                    <div class="u-card u-bg-gray-100">
                        <div class="u-card-body u-text-center">
                            <p class="u-font-semibold">2 Columns</p>
                            <p class="u-text-xs u-text-gray-600">Small screens</p>
                        </div>
                    </div>
                    <div class="u-card u-bg-gray-100">
                        <div class="u-card-body u-text-center">
                            <p class="u-font-semibold">3 Columns</p>
                            <p class="u-text-xs u-text-gray-600">Medium screens</p>
                        </div>
                    </div>
                    <div class="u-card u-bg-gray-100">
                        <div class="u-card-body u-text-center">
                            <p class="u-font-semibold">4 Columns</p>
                            <p class="u-text-xs u-text-gray-600">Large screens</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Spacing Examples -->
    <section class="u-mb-8">
        <h2 class="u-text-2xl u-font-semibold u-text-gray-800 u-mb-4">Spacing Examples</h2>
        
        <div class="u-card">
            <div class="u-card-header">
                <h3 class="u-text-lg u-font-semibold">Margin and Padding</h3>
            </div>
            <div class="u-card-body">
                <div class="u-space-y-4">
                    <div class="u-p-2 u-bg-blue-100 u-border u-border-blue-300">
                        <p class="u-text-sm">Padding 2 (8px)</p>
                    </div>
                    <div class="u-p-4 u-bg-green-100 u-border u-border-green-300">
                        <p class="u-text-sm">Padding 4 (16px)</p>
                    </div>
                    <div class="u-p-6 u-bg-yellow-100 u-border u-border-yellow-300">
                        <p class="u-text-sm">Padding 6 (24px)</p>
                    </div>
                    <div class="u-p-8 u-bg-red-100 u-border u-border-red-300">
                        <p class="u-text-sm">Padding 8 (32px)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 