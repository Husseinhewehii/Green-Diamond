<?php

namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class StaticContentTest extends TestCase
{
    use RefreshDatabase, StaticContentTestingTrait;

    public function testStaticContentSoftDelete(){
        $staticContent = $this->staticContents[0];
        $staticContent->delete();
        $this->assertSoftDeleted($staticContent);
        $this->assertDatabaseCount("static_contents", count($this->staticContents));
    }

    public function testStaticContentPutTextUpdated()
    {
        $staticContentNewText = [
            "en" => $this->firstStaticContent->text." edited en"
        ];

        $payLoad = [
            "text" => $staticContentNewText,
        ];


        $this->put($this->updateUrl, $this->staticContentPayLoad($payLoad));

        $staticContentUpdated = StaticContent::find($this->firstStaticContent->id);
        $this->assertEquals($staticContentUpdated->text, $staticContentNewText['en']);
    }

    public function testStaticContentTranslatableText()
    {
        $payLoad = $this->staticContentPayLoad();

        $this->put($this->updateUrl, $payLoad);


        $first_staticContent_english_text_from_db_before_localization = StaticContent::find($this->firstStaticContent->id)->getTranslation('text', 'en');
        $first_staticContent_english_text_from_db_before_localization_2 = StaticContent::find($this->firstStaticContent->id)->text;

        $first_staticContent_arabic_text_from_db_before_localization = StaticContent::find($this->firstStaticContent->id)->getTranslation('text', 'ar');
        App::setlocale('ar');
        $first_staticContent_arabic_text_from_db_after_localization = StaticContent::find($this->firstStaticContent->id)->text;

        $this->assertEquals($first_staticContent_english_text_from_db_before_localization, $first_staticContent_english_text_from_db_before_localization_2);
        $this->assertEquals($first_staticContent_arabic_text_from_db_before_localization, $first_staticContent_arabic_text_from_db_after_localization);

        $this->assertEquals($first_staticContent_english_text_from_db_before_localization_2, $payLoad['text']['en']);
        $this->assertEquals($first_staticContent_arabic_text_from_db_after_localization, $payLoad['text']['ar']);
    }

    public function testStaticContentPutActivityLog()
    {
        $this->put($this->updateUrl, $this->staticContentPayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstStaticContent->id,
            "subject_type" => get_class($this->firstStaticContent),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
