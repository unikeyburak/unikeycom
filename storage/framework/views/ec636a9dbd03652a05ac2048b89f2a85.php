<?php $__env->startSection('title', __('Bayi Başvurusu') . ' - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', config('app.name') . ' ' . __('bayi başvuru formu.')); ?>

<?php $__env->startSection('content'); ?>
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-center mb-8"><?php echo e(__('Bayi Başvurusu')); ?></h1>
                <p class="text-gray-600 text-center mb-8">
                    <?php echo e(__('Güçlü bayi ağımıza katılmak için aşağıdaki formu doldurun.')); ?>

                </p>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold mb-2"><?php echo e(__('Lütfen aşağıdaki hataları düzeltin:')); ?></p>
                    <ul class="list-disc list-inside text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('dealer.register.submit')); ?>" class="space-y-8">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Şirket Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b"><?php echo e(__('Şirket Bilgileri')); ?></h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Şirket Adı')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="company_name" 
                                       name="company_name" 
                                       value="<?php echo e(old('company_name')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="tax_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Vergi Numarası')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tax_number" 
                                       name="tax_number" 
                                       value="<?php echo e(old('tax_number')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['tax_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="tax_office" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Vergi Dairesi')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tax_office" 
                                       name="tax_office" 
                                       value="<?php echo e(old('tax_office')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['tax_office'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Web Sitesi')); ?>

                                </label>
                                <input type="url" 
                                       id="website" 
                                       name="website" 
                                       value="<?php echo e(old('website')); ?>"
                                       placeholder="https://"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- İletişim Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b"><?php echo e(__('İletişim Bilgileri')); ?></h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Yetkili Adı Soyadı')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="contact_name" 
                                       name="contact_name" 
                                       value="<?php echo e(old('contact_name')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('E-posta Adresi')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo e(old('email')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Telefon')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?php echo e(old('phone')); ?>"
                                       placeholder="0XXX XXX XX XX"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                                    WhatsApp
                                </label>
                                <input type="tel" 
                                       id="whatsapp" 
                                       name="whatsapp" 
                                       value="<?php echo e(old('whatsapp')); ?>"
                                       placeholder="0XXX XXX XX XX"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Adres Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b"><?php echo e(__('Adres Bilgileri')); ?></h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('İl')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="city" 
                                       name="city" 
                                       value="<?php echo e(old('city')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('İlçe')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="district" 
                                       name="district" 
                                       value="<?php echo e(old('district')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Posta Kodu')); ?>

                                </label>
                                <input type="text" 
                                       id="postal_code" 
                                       name="postal_code" 
                                       value="<?php echo e(old('postal_code')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Açık Adres')); ?> <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      required><?php echo e(old('address')); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Giriş Bilgileri -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b"><?php echo e(__('Giriş Bilgileri')); ?></h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Şifre')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                                <p class="mt-1 text-xs text-gray-500"><?php echo e(__('En az 8 karakter')); ?></p>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Şifre Tekrar')); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Şirket Hakkında -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 pb-2 border-b"><?php echo e(__('Ek Bilgiler')); ?></h2>
                        <div>
                            <label for="about" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Şirketiniz Hakkında')); ?>

                            </label>
                            <textarea id="about" 
                                      name="about" 
                                      rows="4"
                                      placeholder="<?php echo e(__('Faaliyet alanlarınız, müşteri portföyünüz vb. hakkında bilgi verebilirsiniz...')); ?>"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 <?php $__errorArgs = ['about'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('about')); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <div>
                        <div class="mb-4">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       required
                                       class="w-4 h-4 mt-1 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                                <span class="ml-2 text-sm text-gray-600">
                                    <a href="<?php echo e(lroute('terms')); ?>" target="_blank" class="text-cyan-600 hover:underline"><?php echo e(__('Kullanım şartlarını')); ?></a> <?php echo e(__('ve')); ?>

                                    <a href="<?php echo e(lroute('privacy')); ?>" target="_blank" class="text-cyan-600 hover:underline"><?php echo e(__('gizlilik politikasını')); ?></a>
                                    <?php echo e(__('okudum, kabul ediyorum.')); ?>

                                </span>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition-colors font-medium text-lg">
                            <?php echo e(__('Başvuruyu Gönder')); ?>

                        </button>
                    </div>
                </form>
                
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        <?php echo e(__('Zaten bayi misiniz?')); ?>

                        <a href="<?php echo e(route('dealer.login')); ?>" class="text-cyan-600 hover:underline font-medium">
                            <?php echo e(__('Giriş yapın')); ?>

                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dealer/register.blade.php ENDPATH**/ ?>