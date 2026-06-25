<?php $__env->startSection('title', 'Teklif Talebi - '.$product->name); ?>
<?php $__env->startSection('header', 'Teklif Talebi Oluştur'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Ürün Bilgisi -->
        <div class="p-6 border-b bg-gray-50">
            <div class="flex items-center">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                <img src="<?php echo e(Storage::url($product->image)); ?>" 
                     alt="<?php echo e($product->name); ?>"
                     class="w-20 h-20 rounded object-cover mr-4">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div>
                    <h2 class="text-xl font-semibold"><?php echo e($product->name); ?></h2>
                    <p class="text-gray-600"><?php echo e($product->active_ingredient); ?> - <?php echo e($product->formulation); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?php echo e(route('dealer.products.quote.submit', $product)); ?>" class="p-6">
            <?php echo csrf_field(); ?>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Miktar ve Birim -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('Miktar')); ?> <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="number" 
                               name="quantity" 
                               value="<?php echo e(old('quantity')); ?>"
                               min="1"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required>
                        <select name="unit"
                                class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                            <option value="Adet" <?php echo e(old('unit') == 'Adet' ? 'selected' : ''); ?>><?php echo e(__('Adet')); ?></option>
                            <option value="Kg" <?php echo e(old('unit') == 'Kg' ? 'selected' : ''); ?>><?php echo e(__('Kg')); ?></option>
                            <option value="Lt" <?php echo e(old('unit') == 'Lt' ? 'selected' : ''); ?>><?php echo e(__('Lt')); ?></option>
                            <option value="Ton" <?php echo e(old('unit') == 'Ton' ? 'selected' : ''); ?>><?php echo e(__('Ton')); ?></option>
                            <option value="Paket" <?php echo e(old('unit') == 'Paket' ? 'selected' : ''); ?>><?php echo e(__('Paket')); ?></option>
                        </select>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Teslimat Şehri -->
                <div>
                    <label for="delivery_city" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('Teslimat Şehri')); ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="delivery_city" 
                           name="delivery_city" 
                           value="<?php echo e(old('delivery_city')); ?>"
                           placeholder="Örn: İstanbul"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['delivery_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['delivery_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- İstenen Teslimat Tarihi -->
                <div>
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('İstenen Teslimat Tarihi')); ?>

                    </label>
                    <input type="date" 
                           id="delivery_date" 
                           name="delivery_date" 
                           value="<?php echo e(old('delivery_date')); ?>"
                           min="<?php echo e(date('Y-m-d')); ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Kullanım Amacı -->
                <div>
                    <label for="usage_purpose" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('Kullanım Amacı')); ?>

                    </label>
                    <input type="text" 
                           id="usage_purpose" 
                           name="usage_purpose" 
                           value="<?php echo e(old('usage_purpose')); ?>"
                           placeholder="Örn: Buğday tarlası için"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['usage_purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['usage_purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Ödeme Şekli -->
                <div class="md:col-span-2">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('Tercih Edilen Ödeme Şekli')); ?>

                    </label>
                    <select id="payment_method" 
                            name="payment_method"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value=""><?php echo e(__('Seçiniz')); ?></option>
                        <option value="Nakit" <?php echo e(old('payment_method') == 'Nakit' ? 'selected' : ''); ?>><?php echo e(__('Nakit')); ?></option>
                        <option value="Vadeli" <?php echo e(old('payment_method') == 'Vadeli' ? 'selected' : ''); ?>><?php echo e(__('Vadeli')); ?></option>
                        <option value="Kredi Kartı" <?php echo e(old('payment_method') == 'Kredi Kartı' ? 'selected' : ''); ?>><?php echo e(__('Kredi Kartı')); ?></option>
                        <option value="Havale/EFT" <?php echo e(old('payment_method') == 'Havale/EFT' ? 'selected' : ''); ?>><?php echo e(__('Havale/EFT')); ?></option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Notlar -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e(__('Ek Notlar')); ?>

                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="4"
                              placeholder="<?php echo e(__('Varsa özel isteklerinizi belirtebilirsiniz...')); ?>"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('notes')); ?></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            
            <!-- Bilgilendirme -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-blue-700">
                        <?php echo e(__('Teklif talebiniz satış ekibimize iletilecek ve en kısa sürede size dönüş yapılacaktır.')); ?>

                    </p>
                </div>
            </div>
            
            <!-- Butonlar -->
            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                    <?php echo e(__('Teklif Talebini Gönder')); ?>

                </button>

                <a href="<?php echo e(route('dealer.products.show', $product)); ?>"
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    <?php echo e(__('İptal')); ?>

                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dealer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/products/quote.blade.php ENDPATH**/ ?>